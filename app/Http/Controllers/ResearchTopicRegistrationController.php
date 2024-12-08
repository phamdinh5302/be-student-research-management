<?php

namespace App\Http\Controllers;

use App\Models\ResearchTopic;
use App\Models\StudentTopic;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Lecturer;

class ResearchTopicRegistrationController extends Controller
{
    public function index()
    {
        // Lấy tất cả các đề tài chưa có sinh viên đăng ký
        // Lấy tất cả các đề tài chưa có sinh viên đăng ký
        $topics = ResearchTopic::whereDoesntHave('students')->get();

        // Lấy tất cả sinh viên chưa đăng ký đề tài
        $students = Student::whereDoesntHave('researchTopics')->get();

        // Lấy tất cả giảng viên chưa đạt số lượng đề tài tối đa
        $lecturers = Lecturer::whereHas('researchTopics', function ($query) {
            $query->havingRaw('count(*) < tbl_lecturers.number_of_topics');
        })->get();

        return view('research_registration', compact('topics', 'students', 'lecturers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:tbl_research_topics,topic_id',
            'lecturer_id' => 'required|integer|exists:tbl_lecturers,lecturer_id',
            'leader_id' => 'required|exists:tbl_students,student_id',
            'students' => 'nullable|array|max:3', // Cho phép không chọn thành viên
            'students.*' => 'exists:tbl_students,student_id',
            'research_goal' => 'required|string',
            'content' => 'required|string',
        ]);

        // Đăng ký sinh viên vào đề tài
        $topic = ResearchTopic::find($request->topic_id);

        // Xử lý trưởng nhóm
        $leader = Student::find($request->leader_id);
        // Nếu có thành viên nhóm, merge với leader
        $students = $request->students ? array_merge([$leader->student_id], $request->students) : [$leader->student_id];
        
        // Thêm sinh viên vào đề tài
        foreach ($students as $student_id) {
            StudentTopic::create([
                'topic_id' => $topic->topic_id,
                'student_id' => $student_id,
                'is_leader' => $student_id == $leader->student_id ? 1 : 0,
            ]);
        }

        // Cập nhật mục tiêu và nội dung của đề tài
        $topic->update([
            'lecturer_id' => $request->lecturer_id,
            'research_goal' => $request->research_goal,
            'content' => $request->content,
        ]);

        return redirect()->route('research_topics.index')->with('success', 'Đăng ký đề tài thành công!');
    }
}


