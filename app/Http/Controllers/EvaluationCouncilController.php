<?php

namespace App\Http\Controllers;

use App\Models\EvaluationCouncil;
use App\Models\Lecturer;
use App\Models\ResearchTopic;
use Illuminate\Http\Request;

class EvaluationCouncilController extends Controller
{
    // Hiển thị danh sách các hội đồng
    public function index()
    {
        $councils = EvaluationCouncil::all();
        return view('evaluation_councils.index', compact('councils'));
    }

    // Hiển thị form tạo mới hội đồng
    public function create()
    {
        $lecturers = Lecturer::all();
        $topics = ResearchTopic::all();
        return view('evaluation_councils.create', compact('lecturers', 'topics'));
    }
    public function show($id)
    {
        $council = EvaluationCouncil::with(['lecturers', 'topics'])->findOrFail($id);

        // Tách giảng viên theo vai trò
        $roles = [
            'chairman' => $council->lecturers->where('pivot.duty', 'Chủ tịch hội đồng')->first(),
            'member' => $council->lecturers->where('pivot.duty', 'Ủy viên')->first(),
            'secretary' => $council->lecturers->where('pivot.duty', 'Thư ký')->first(),
        ];

        return view('evaluation_councils.show', compact('council', 'roles'));
    }



    // Lưu hội đồng mới
    public function store(Request $request)
    {
        $request->validate([
            'council_name' => 'required|string|max:255',
            'council_level' => 'required|string|max:255',
            'time' => 'required|date',
            'location' => 'required|string|max:255',
            'lecturer_roles.chairman' => 'required|exists:tbl_lecturers,lecturer_id',
            'lecturer_roles.member' => 'required|exists:tbl_lecturers,lecturer_id|different:lecturer_roles.chairman',
            'lecturer_roles.secretary' => 'required|exists:tbl_lecturers,lecturer_id|different:lecturer_roles.chairman|different:lecturer_roles.member',
            'topic_ids' => 'required|array',
            'topic_ids.*' => 'exists:tbl_research_topics,topic_id',
        ]);

        // Tạo hội đồng mới
        $council = EvaluationCouncil::create($request->only('council_name', 'council_level', 'time', 'location'));

        // Gán giảng viên với vai trò cho hội đồng
        $council->lecturers()->attach($request->lecturer_roles['chairman'], ['duty' => 'Chủ tịch hội đồng']);
        $council->lecturers()->attach($request->lecturer_roles['member'], ['duty' => 'Ủy viên']);
        $council->lecturers()->attach($request->lecturer_roles['secretary'], ['duty' => 'Thư ký']);

        // Gán đề tài cho hội đồng
        foreach ($request->topic_ids as $topic_id) {
            $council->topics()->attach($topic_id);
        }

        return redirect()->route('evaluation_councils.index')->with('success', 'Hội đồng đã được tạo thành công!');
    }

    // Hiển thị form chỉnh sửa hội đồng
    public function edit($id)
    {
        $council = EvaluationCouncil::with('lecturers')->findOrFail($id);
        $lecturers = Lecturer::all();
        $topics = ResearchTopic::all();

        $roles = [
            'chairman' => $council->lecturers->where('pivot.duty', 'Chủ tịch hội đồng')->first(),
            'member' => $council->lecturers->where('pivot.duty', 'Ủy viên')->first(),
            'secretary' => $council->lecturers->where('pivot.duty', 'Thư ký')->first(),
        ];

        return view('evaluation_councils.edit', compact('council', 'lecturers', 'topics', 'roles'));
    }

    // Cập nhật hội đồng
    public function update(Request $request, $id)
    {
        $request->validate([
            'council_name' => 'required|string|max:255',
            'council_level' => 'required|string|max:255',
            'time' => 'required|date',
            'location' => 'required|string|max:255',
            'lecturer_roles.chairman' => 'required|exists:tbl_lecturers,lecturer_id',
            'lecturer_roles.member' => 'required|exists:tbl_lecturers,lecturer_id|different:lecturer_roles.chairman',
            'lecturer_roles.secretary' => 'required|exists:tbl_lecturers,lecturer_id|different:lecturer_roles.chairman|different:lecturer_roles.member',
            'topic_ids' => 'required|array',
            'topic_ids.*' => 'exists:tbl_research_topics,topic_id',
        ]);

        // Cập nhật hội đồng
        $council = EvaluationCouncil::findOrFail($id);
        $council->update($request->only('council_name', 'council_level', 'time', 'location'));

        // Xóa giảng viên cũ và gán lại
        $council->lecturers()->detach();
        $council->lecturers()->attach($request->lecturer_roles['chairman'], ['duty' => 'Chủ tịch hội đồng']);
        $council->lecturers()->attach($request->lecturer_roles['member'], ['duty' => 'Ủy viên']);
        $council->lecturers()->attach($request->lecturer_roles['secretary'], ['duty' => 'Thư ký']);

        // Gán lại đề tài cho hội đồng
        $council->topics()->sync($request->topic_ids);

        return redirect()->route('evaluation_councils.index')->with('success', 'Hội đồng đã được cập nhật thành công!');
    }


    // Xóa hội đồng
    public function destroy($id)
    {
        $council = EvaluationCouncil::findOrFail($id);
        $council->lecturers()->detach();
        $council->topics()->detach();
        $council->delete();

        return redirect()->route('evaluation_councils.index')->with('success', 'Hội đồng đã được xóa thành công!');
    }
}
