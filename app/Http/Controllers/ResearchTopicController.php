<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResearchTopic;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\ResearchDirection;

class ResearchTopicController extends Controller
{
    // Hiển thị danh sách đề tài
    public function index()
    {
        // Lấy thông tin người dùng hiện tại
        $user = auth()->user();
        $roleId = $user->role_id;
    
        // Khởi tạo query chung
        $queryWithoutStudents = ResearchTopic::doesntHave('students')->with('lecturer');
        $queryWithStudents = ResearchTopic::has('students')->with(['lecturer', 'students']);
    
        if ($roleId == 1) {
            // Admin: Xem tất cả
            $topicsWithoutStudents = $queryWithoutStudents->orderBy('created_at', 'desc')->get();
            $topicsWithStudents = $queryWithStudents->orderBy('updated_at', 'desc')->get();
        } elseif ($roleId == 3) {
            // Giảng viên: Chỉ xem các đề tài của mình
            $topicsWithoutStudents = $queryWithoutStudents->where('lecturer_id', $user->lecturer->lecturer_id)
                ->orderBy('created_at', 'desc')->get();
            $topicsWithStudents = $queryWithStudents->where('lecturer_id', $user->lecturer->lecturer_id)
                ->orderBy('updated_at', 'desc')->get();
        } elseif ($roleId == 2) {
            // Sinh viên: Chỉ xem các đề tài mình tham gia
            $topicsWithoutStudents = collect(); // Không áp dụng cho sinh viên
            $topicsWithStudents = $queryWithStudents->whereHas('students', function ($query) use ($user) {
                $query->where('tbl_student_topics.student_id', $user->student->student_id);
            })->orderBy('updated_at', 'desc')->get();
        } else {
            // Không có quyền truy cập
            abort(403, 'Bạn không có quyền truy cập');
        }
    
        // Lấy danh sách hướng nghiên cứu
        $researchDirections = ResearchDirection::all();
    
        return view('research_topics.index', compact('topicsWithoutStudents', 'topicsWithStudents', 'researchDirections'));
    }

    // Hiển thị chi tiết đề tài
    public function show($id)
    {
        $topic = ResearchTopic::with(['lecturer', 'students', 'researchDirections'])->findOrFail($id);
        return view('research_topics.show', compact('topic'));
    }

    // Hiển thị form tạo đề tài
    public function create()
    {
        $lecturers = Lecturer::all();
        $researchDirections = ResearchDirection::all(); // Lấy danh sách hướng nghiên cứu
        return view('research_topics.create', compact('lecturers', 'researchDirections'));
    }

    // Lưu đề tài mới
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'topic_name' => 'required|string|max:255',
            'research_goal' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'lecturer_id' => 'nullable|integer|exists:tbl_lecturers,lecturer_id',
            'research_direction_id' => 'nullable|integer|exists:tbl_research_directions,research_direction_id', // Thêm dòng này
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'nullable|string|max:50',
        ]);

        ResearchTopic::create($validatedData);

        return redirect()->route('research_topics.index')->with('success', 'Research topic created successfully');
    }

    // Hiển thị form chỉnh sửa đề tài
    public function edit($id)
    {
        $topic = ResearchTopic::findOrFail($id);
        $lecturers = Lecturer::all();
        $researchDirections = ResearchDirection::all(); // Lấy danh sách hướng nghiên cứu
        return view('research_topics.edit', compact('topic', 'lecturers','researchDirections'));
    }

    // Cập nhật đề tài
    public function update(Request $request, $id)
    {
        $topic = ResearchTopic::findOrFail($id);

        $validatedData = $request->validate([
            'topic_name' => 'required|string|max:255',
            'research_goal' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'lecturer_id' => 'nullable|integer|exists:tbl_lecturers,lecturer_id',
            'research_direction_id' => 'nullable|integer|exists:tbl_research_directions,research_direction_id', // Thêm dòng này
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'nullable|string|max:50',
        ]);

        $topic->update($validatedData);

        return redirect()->route('research_topics.index')->with('success', 'Research topic updated successfully');
    }
    //cập nhật trạng thái
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Chờ duyệt,Đã duyệt,Hủy',
        ]);

        $topic = ResearchTopic::findOrFail($id);
        $topic->update([
            'status' => $request->status,
        ]);
        //return redirect()->route('research_topics.index')->with('success', 'Đã cập nhật đề tài thành công!');
        return response()->json(['message' => 'Trạng thái đã được cập nhật.', 'status' => $topic->status]);
    }

    // Xóa đề tài
    public function destroy($id)
    {
        $topic = ResearchTopic::findOrFail($id);
        $topic->delete();

        return redirect()->route('research_topics.index')->with('success', 'Research topic deleted successfully');
    }
}
