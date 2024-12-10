<?php

namespace App\Http\Controllers;

use App\Models\ResearchTopic;
use App\Models\StudentTopic;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Lecturer;
use App\Models\ResearchDirection;

class ResearchTopicRegistrationController extends Controller
{
    public function index()
    {
        $researchDirections = ResearchDirection::with(['topics', 'lecturers'])->get();
        // Lấy tất cả sinh viên chưa đăng ký đề tài
        $students = Student::whereDoesntHave('researchTopics')->get();

        return view('research_registration.index', compact('researchDirections', 'students'));
    }

    public function edit($id)
    {
        $topic = ResearchTopic::with(['students' => function ($query) {
            $query->select('tbl_students.student_id', 'tbl_students.student_name', 'is_leader');
        }, 'lecturer'])->findOrFail($id);

        $researchDirections = ResearchDirection::all();
        $lecturers = Lecturer::all();

        // Lấy các sinh viên không thuộc bất kỳ đề tài nào hoặc thuộc chính đề tài đang chỉnh sửa
        $students = Student::whereDoesntHave('researchTopics', function ($query) use ($id) {
            $query->where('tbl_research_topics.topic_id', '!=', $id);
        })->orWhereHas('researchTopics', function ($query) use ($id) {
            $query->where('tbl_research_topics.topic_id', $id);
        })->get();

        return view('research_registration.edit', compact('topic', 'researchDirections', 'lecturers', 'students'));
    }


    public function getTopicsAndLecturers(Request $request)
    {
        $directionId = $request->input('research_direction_id');
        // Kiểm tra nếu directionId là null
        if (is_null($directionId)) {
            return response()->json(['error' => 'Research direction ID is required.'], 400);
        }
        // Lấy danh sách các đề tài theo hướng nghiên cứu và chưa có sinh viên đăng ký
        $topics = ResearchTopic::where('research_direction_id', $directionId)
            ->whereDoesntHave('students')
            ->get();

        // Lấy danh sách giảng viên thuộc hướng nghiên cứu và chưa vượt quá số lượng đề tài tối đa
        $lecturers = Lecturer::whereHas('researchDirections', function ($query) use ($directionId) {
            $query->where('tbl_lecturer_research_directions.research_direction_id', $directionId); // Định rõ bảng
        })
            ->whereHas('researchTopics', function ($query) {
                $query->havingRaw('count(*) < tbl_lecturers.number_of_topics'); // Giữ nguyên điều kiện
            })
            ->get();

        return response()->json(['topics' => $topics, 'lecturers' => $lecturers]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'topic_id' => 'nullable|exists:tbl_research_topics,topic_id',
            'topic_name' => 'nullable|string|max:255',
            'research_direction_id' => 'required|exists:tbl_research_directions,research_direction_id',
            'lecturer_id' => 'required|exists:tbl_lecturers,lecturer_id',
            'leader_id' => 'required|exists:tbl_students,student_id',
            'students' => 'nullable|array|max:3',
            'students.*' => 'exists:tbl_students,student_id',
            'research_goal' => 'required|string',
            'content' => 'required|string',
        ]);

        // Xử lý tạo mới hoặc cập nhật đề tài
        if ($request->topic_id) {
            $topic = ResearchTopic::find($request->topic_id);
            $topic->update([
                'lecturer_id' => $request->lecturer_id,
                'research_goal' => $request->research_goal,
                'content' => $request->content,
            ]);
        } else {
            $topic = ResearchTopic::create([
                'topic_name' => $request->topic_name,
                'research_direction_id' => $request->research_direction_id,
                'lecturer_id' => $request->lecturer_id,
                'research_goal' => $request->research_goal,
                'content' => $request->content,

            ]);
        }

        // Gắn sinh viên vào đề tài
        $leader = Student::find($request->leader_id);
        $students = $request->students ? array_merge([$leader->student_id], $request->students) : [$leader->student_id];

        foreach ($students as $student_id) {
            StudentTopic::create([
                'topic_id' => $topic->topic_id,
                'student_id' => $student_id,
                'is_leader' => $student_id == $leader->student_id ? 1 : 0,
            ]);
        }

        return redirect()->route('research_topics.index')->with('success', 'Đăng ký đề tài thành công!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'topic_name' => 'required|string|max:255',
            'research_direction_id' => 'required|exists:tbl_research_directions,research_direction_id',
            'lecturer_id' => 'required|exists:tbl_lecturers,lecturer_id',
            'leader_id' => 'required|exists:tbl_students,student_id',
            'students' => 'nullable|array|max:3',
            'students.*' => 'exists:tbl_students,student_id',
            'research_goal' => 'required|string',
            'content' => 'required|string',
        ]);

        $topic = ResearchTopic::findOrFail($id);

        $topic->update([
            'topic_name' => $request->topic_name,
            'research_direction_id' => $request->research_direction_id,
            'lecturer_id' => $request->lecturer_id,
            'research_goal' => $request->research_goal,
            'content' => $request->content,
        ]);

        // Cập nhật lại danh sách sinh viên
        StudentTopic::where('topic_id', $topic->topic_id)->delete();

        $leader = Student::find($request->leader_id);
        $students = $request->students ? array_merge([$leader->student_id], $request->students) : [$leader->student_id];

        foreach ($students as $student_id) {
            StudentTopic::create([
                'topic_id' => $topic->topic_id,
                'student_id' => $student_id,
                'is_leader' => $student_id == $leader->student_id ? 1 : 0,
            ]);
        }

        return redirect()->route('research_topics.index')->with('success', 'Đã cập nhật đề tài thành công!');
    }

}
