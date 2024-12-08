@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Đăng ký Đề tài Nghiên cứu</h1>

    <form action="{{ route('research_registration.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="topic_id" class="form-label">Chọn đề tài</label>
            <select name="topic_id" id="topic_id" class="form-select" required>
                <option value="">Chọn đề tài</option>
                @foreach ($topics as $topic)
                    <option value="{{ $topic->topic_id }}">{{ $topic->topic_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="lecturer_id" class="form-label">Giảng viên hướng dẫn</label>
            <select name="lecturer_id" id="lecturer_id" class="form-select" required>
                <option value="">Chọn giảng viên</option>
                @foreach ($lecturers as $lecturer)
                    <option value="{{ $lecturer->lecturer_id }}">{{ $lecturer->lecturer_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="leader_id" class="form-label">Chọn trưởng nhóm</label>
            <select name="leader_id" id="leader_id" class="form-select" required>
                <option value="">Chọn trưởng nhóm</option>
                @foreach ($students as $student)
                    <option value="{{ $student->student_id }}">{{ $student->student_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="students" class="form-label">Chọn thành viên nhóm (tối đa 3 thành viên)</label>
            <select name="students[]" id="students" class="form-select" multiple >
                <option value="">Chọn thành viên nhóm</option>
                @foreach ($students as $student)
                    <option value="{{ $student->student_id }}">{{ $student->student_name }}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Bạn có thể chọn tối đa 3 thành viên ngoài trưởng nhóm.</small>
        </div>

        <div class="mb-3">
            <label for="research_goal" class="form-label">Mục tiêu</label>
            <textarea name="research_goal" id="research_goal" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Nội dung</label>
            <textarea name="content" id="content" class="form-control" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Đăng ký</button>
        <a href="{{ route('research_topics.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
