<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResearchTopic;
use App\Models\Lecturer;
use App\Models\Student;

class ResearchTopicController extends Controller
{
    // Hiển thị danh sách đề tài
    public function index()
    {
        // Đề tài chưa có sinh viên đăng ký
        $topicsWithoutStudents = ResearchTopic::doesntHave('students')
            ->with('lecturer')
            ->get();

        // Đề tài đã có sinh viên đăng ký
        $topicsWithStudents = ResearchTopic::has('students')
            ->with(['lecturer', 'students'])
            ->get();

        return view('research_topics.index', compact('topicsWithoutStudents', 'topicsWithStudents'));
    }

    // Hiển thị chi tiết đề tài
    public function show($id)
    {
        $topic = ResearchTopic::with(['lecturer', 'students'])->findOrFail($id);
        return view('research_topics.show', compact('topic'));
    }

    // Hiển thị form tạo đề tài
    public function create()
    {
        $lecturers = Lecturer::all();
        return view('research_topics.create', compact('lecturers'));
    }

    // Lưu đề tài mới
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'topic_name' => 'required|string|max:255',
            'research_goal' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'lecturer_id' => 'nullable|integer|exists:tbl_lecturers,lecturer_id',
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
        return view('research_topics.edit', compact('topic', 'lecturers'));
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
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'nullable|string|max:50',
        ]);

        $topic->update($validatedData);

        return redirect()->route('research_topics.index')->with('success', 'Research topic updated successfully');
    }

    // Xóa đề tài
    public function destroy($id)
    {
        $topic = ResearchTopic::findOrFail($id);
        $topic->delete();

        return redirect()->route('research_topics.index')->with('success', 'Research topic deleted successfully');
    }
}
