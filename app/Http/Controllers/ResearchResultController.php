<?php

namespace App\Http\Controllers;

use App\Models\ResearchResult;
use App\Models\ResearchTopic;
use Illuminate\Http\Request;

class ResearchResultController extends Controller
{
    public function index()
    {
        // Lấy tất cả kết quả nghiên cứu kèm thông tin đề tài
        $results = ResearchResult::with('topic')->get();
        return view('research_results.index', compact('results'));
    }

    public function create()
    {
        $topics = ResearchTopic::doesntHave('results')
            ->has('students') // Chỉ lấy những đề tài có sinh viên đăng ký
            ->with('students') // Lấy thông tin sinh viên
            ->get(); // Lấy các đề tài chưa có kết quả
        return view('research_results.create', compact('topics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:tbl_research_topics,topic_id',
            'score' => 'nullable|numeric|min:0|max:10',
            'feedback' => 'nullable|string|max:1000',
            'result_description' => 'nullable|string|max:2000',
        ]);

        ResearchResult::create($request->all());

        return redirect()->route('research_results.index')->with('success', 'Thêm kết quả nghiên cứu thành công.');
    }

    public function show($id)
    {
        $result = ResearchResult::with('topic')->findOrFail($id);
        return view('research_results.show', compact('result'));
    }

    public function edit($id)
    {
        $result = ResearchResult::findOrFail($id);
        return view('research_results.edit', compact('result'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'score' => 'required|numeric|min:0|max:10',
            'feedback' => 'nullable|string|max:1000',
            'result_description' => 'nullable|string|max:2000',
        ]);

        $result = ResearchResult::findOrFail($id);
        $result->update($request->all());

        return redirect()->route('research_results.index')->with('success', 'Cập nhật kết quả thành công.');
    }

    public function destroy($id)
    {
        $result = ResearchResult::findOrFail($id);
        $result->delete();

        return redirect()->route('research_results.index')->with('success', 'Xóa kết quả thành công.');
    }
}
