<?php

namespace App\Http\Controllers;

use App\Models\ResearchProgress;
use App\Models\ResearchTopic;
use Illuminate\Http\Request;

class ResearchProgressController extends Controller
{
    // Hiển thị danh sách tiến độ nghiên cứu
    public function index()
    {
        $researchProgresses = ResearchProgress::with('topic')->get();
        return view('research_progress.index', compact('researchProgresses'));
    }

    // Hiển thị form tạo tiến độ nghiên cứu mới
    public function create()
    {
        $topics = ResearchTopic::has('students') // Chỉ lấy những đề tài có sinh viên đăng ký
        ->with('students') // Lấy thông tin sinh viên
        ->get();
        //$topics = ResearchTopic::all();
        return view('research_progress.create', compact('topics'));
    }

    // Lưu tiến độ nghiên cứu mới
    public function store(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:tbl_research_topics,topic_id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'task_description' => 'required|string',
            'report_content' => 'nullable|string',
            'report_url' => 'nullable|url', // Kiểm tra URL hợp lệ
            'report_link_name' => 'nullable|string', // Tên đường link hiển thị
            // 'status' => 'required|string',
        ]);

        ResearchProgress::create($request->all());
        return redirect()->route('research_progress.index')->with('success', 'Tiến độ nghiên cứu đã được thêm thành công!');
    }

    // Hiển thị chi tiết tiến độ nghiên cứu
    public function show($id)
    {
        $progress = ResearchProgress::with('topic')->findOrFail($id);
        return view('research_progress.show', compact('progress'));
    }

    // Hiển thị form chỉnh sửa tiến độ nghiên cứu
    public function edit($id)
    {
        $progress = ResearchProgress::findOrFail($id);
        $topics = ResearchTopic::all();
        return view('research_progress.edit', compact('progress', 'topics'));
    }

    // Cập nhật tiến độ nghiên cứu
    public function update(Request $request, $id)
    {
        $request->validate([
            'topic_id' => 'required|exists:tbl_research_topics,topic_id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'task_description' => 'required|string',
            'report_content' => 'nullable|string',
            'report_url' => 'nullable|url', // Kiểm tra URL hợp lệ
            'report_link_name' => 'nullable|string', // Tên đường link hiển thị
            //'status' => 'required|string',
        ]);

        $progress = ResearchProgress::findOrFail($id);
        $progress->update($request->all());
        return redirect()->route('research_progress.index')->with('success', 'Tiến độ nghiên cứu đã được cập nhật thành công!');
    }

    // Xóa tiến độ nghiên cứu
    public function destroy($id)
    {
        $progress = ResearchProgress::findOrFail($id);
        $progress->delete();
        return redirect()->route('research_progress.index')->with('success', 'Tiến độ nghiên cứu đã được xóa!');
    }
}
