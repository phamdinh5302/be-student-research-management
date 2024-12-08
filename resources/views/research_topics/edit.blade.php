@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Chỉnh sửa Đề tài Nghiên cứu</h1>
    <form action="{{ route('research_topics.update', $topic->topic_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="topic_name" class="form-label">Tên đề tài</label>
            <input type="text" name="topic_name" id="topic_name" class="form-control" value="{{ $topic->topic_name }}" required>
        </div>
        <div class="mb-3">
            <label for="research_goal" class="form-label">Mục tiêu</label>
            <textarea name="research_goal" id="research_goal" rows="3" class="form-control" required>{{ $topic->research_goal }}</textarea>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Nội dung</label>
            <textarea name="content" id="content" rows="4" class="form-control" required>{{ $topic->content }}</textarea>
        </div>
        <div class="mb-3">
            <label for="lecturer_id" class="form-label">Giảng viên hướng dẫn</label>
            <select name="lecturer_id" id="lecturer_id" class="form-select" required>
                <option value="">Chọn giảng viên</option>
                @foreach ($lecturers as $lecturer)
                    <option value="{{ $lecturer->lecturer_id }}" {{ $topic->lecturer_id == $lecturer->lecturer_id ? 'selected' : '' }}>
                        {{ $lecturer->lecturer_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Ngày bắt đầu</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $topic->start_date }}" required>
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">Ngày kết thúc</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $topic->end_date }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('research_topics.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
