<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\ResearchTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProposalController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $roleId = $user->role_id;

        if ($roleId == 1) {
            // Quản trị viên xem tất cả đề cương
            $proposals = Proposal::with('topic')->get();
        } elseif ($roleId == 3) {
            // Giảng viên chỉ xem các đề cương thuộc đề tài mà họ hướng dẫn
            $proposals = Proposal::whereHas('topic', function ($query) use ($user) {
                $query->where('lecturer_id',$user->lecturer->lecturer_id);
            })->with('topic')->get();
        } elseif ($roleId == 2) {
            // Sinh viên chỉ xem các đề cương thuộc đề tài mà họ tham gia
            $proposals = Proposal::whereHas('topic.students', function ($query) use ($user) {
                $query->where('tbl_student_topics.student_id', $user->student->student_id);
            })->with('topic')->get();
        } else {
            // Trường hợp không xác định, trả về danh sách trống
            $proposals = collect();
        }

        return view('proposals.index', compact('proposals'));
    }


    public function create()
    {
        // Lấy danh sách các đề tài đã có sinh viên đăng ký
        $topics = ResearchTopic::has('students') // Chỉ lấy những đề tài có sinh viên đăng ký
            ->with('students') // Lấy thông tin sinh viên
            ->get();

        return view('proposals.create', compact('topics'));
    }


    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $request->validate([
            'topic_id' => 'required|exists:tbl_research_topics,topic_id',
            'proposal_content' => 'nullable|string',
            'proposal_file' => 'nullable|mimes:docx|max:10240',  // Giới hạn file .docx
        ]);

        // Lưu file nếu có và giữ nguyên tên file
        $filePath = null;
        if ($request->hasFile('proposal_file')) {
            $file = $request->file('proposal_file');
            $fileName = $file->getClientOriginalName();  // Lấy tên file gốc
            $filePath = $file->storeAs('proposals', $fileName, 'public');  // Lưu file với tên gốc
        }

        // Tạo mới đề cương
        Proposal::create([
            'topic_id' => $request->topic_id,
            'proposal_content' => $request->proposal_content,
            'proposal_file' => $filePath,
            'submission_date' => now(),
            'approval_status' => 'Đang chờ duyệt', // Mặc định trạng thái là chờ phê duyệt
        ]);

        return redirect()->route('proposals.index')->with('success', 'Đề cương đã được tạo thành công.');
    }


    public function show($id)
    {
        // Lấy đề cương theo id
        $proposal = Proposal::with('topic')->findOrFail($id);
        return view('proposals.show', compact('proposal'));
    }

    public function edit($id)
    {
        // Lấy đề cương và danh sách các đề tài nghiên cứu
        $proposal = Proposal::findOrFail($id);
        $topics = ResearchTopic::has('students') // Chỉ lấy những đề tài có sinh viên đăng ký
            ->with('students') // Lấy thông tin sinh viên
            ->get();
        return view('proposals.edit', compact('proposal', 'topics'));
    }

    public function update(Request $request, $id)
    {
        // Xác thực dữ liệu
        try {
            $request->validate([
                'topic_id' => 'required|exists:tbl_research_topics,topic_id',
                'proposal_content' => 'nullable|string',
                'proposal_file' => 'nullable|mimes:docx|max:10240',  // Giới hạn file .docx
            ]);

            // Lấy đề cương cũ
            $proposal = Proposal::findOrFail($id);

            // Cập nhật file nếu có
            if ($request->hasFile('proposal_file')) {
                // Xóa file cũ nếu có
                if ($proposal->proposal_file && Storage::exists($proposal->proposal_file)) {
                    Storage::delete($proposal->proposal_file);
                }
                $file = $request->file('proposal_file');
                $fileName = $file->getClientOriginalName();  // Lấy tên file gốc
                $filePath = $file->storeAs('proposals', $fileName, 'public');
            } else {
                $filePath = $proposal->proposal_file;
            }

            // Cập nhật thông tin đề cương
            $proposal->update([
                'topic_id' => $request->topic_id,
                'proposal_content' => $request->proposal_content,
                'proposal_file' => $filePath,
            ]);

            return redirect()->route('proposals.index')->with('success', 'Đề cương đã được cập nhật.');
        } catch (\Exception $e) {
            // Trả về lỗi nếu có
            return response()->json([
                'message' => 'Có lỗi xảy ra khi cập nhật đề cương. ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }


    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Đang chờ duyệt,Đã phê duyệt,Bị từ chối',
        ]);

        $proposal = Proposal::findOrFail($id);
        $proposal->update([
            'approval_status' => $request->status,
        ]);

        return response()->json(['message' => 'Trạng thái đã được cập nhật thành công.']);
    }


    public function destroy($id)
    {
        // Xóa đề cương
        $proposal = Proposal::findOrFail($id);
        if ($proposal->proposal_file && Storage::exists($proposal->proposal_file)) {
            Storage::delete($proposal->proposal_file);
        }
        $proposal->delete();

        return redirect()->route('proposals.index')->with('success', 'Đề cương đã được xóa.');
    }
}
