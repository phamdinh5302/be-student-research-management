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
        $council = EvaluationCouncil::findOrFail($id);
        return view('evaluation_councils.show', compact('council'));
    }


    // Lưu hội đồng mới
    public function store(Request $request)
    {
        $request->validate([
            'council_name' => 'required|string|max:255',
            'council_level' => 'required|string|max:255',
            'time' => 'required|date',
            'location' => 'required|string|max:255',
            'lecturer_ids' => 'required|array',
            'lecturer_ids.*' => 'exists:tbl_lecturers,lecturer_id',
            'topic_ids' => 'required|array',
            'topic_ids.*' => 'exists:tbl_research_topics,topic_id',
        ]);

        // Tạo hội đồng mới
        $council = EvaluationCouncil::create($request->only('council_name', 'council_level', 'time', 'location'));

        // Gán giảng viên cho hội đồng
        foreach ($request->lecturer_ids as $lecturer_id) {
            $council->lecturers()->attach($lecturer_id);
        }

        // Gán đề tài cho hội đồng
        foreach ($request->topic_ids as $topic_id) {
            $council->topics()->attach($topic_id);
        }

        return redirect()->route('evaluation_councils.index')->with('success', 'Hội đồng đã được tạo thành công!');
    }

    // Hiển thị form chỉnh sửa hội đồng
    public function edit($id)
    {
        $council = EvaluationCouncil::findOrFail($id);
        $lecturers = Lecturer::all();
        $topics = ResearchTopic::all();
        return view('evaluation_councils.edit', compact('council', 'lecturers', 'topics'));
    }

    // Cập nhật hội đồng
    public function update(Request $request, $id)
    {
        $request->validate([
            'council_name' => 'required|string|max:255',
            'council_level' => 'required|string|max:255',
            'time' => 'required|date',
            'location' => 'required|string|max:255',
            'lecturer_ids' => 'required|array',
            'lecturer_ids.*' => 'exists:tbl_lecturers,lecturer_id',
            'topic_ids' => 'required|array',
            'topic_ids.*' => 'exists:tbl_research_topics,topic_id',
        ]);

        // Cập nhật hội đồng
        $council = EvaluationCouncil::findOrFail($id);
        $council->update($request->only('council_name', 'council_level', 'time', 'location'));

        // Gán lại giảng viên cho hội đồng
        $council->lecturers()->sync($request->lecturer_ids);

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
