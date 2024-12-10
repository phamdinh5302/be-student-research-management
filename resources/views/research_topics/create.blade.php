@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Thêm Đề tài Nghiên cứu</h1>
    <form action="{{ route('research_topics.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="research_direction_id" class="form-label">Hướng nghiên cứu</label>
            <select name="research_direction_id" id="research_direction_id" class="form-select">
                <option value="">Chọn hướng nghiên cứu</option>
                @foreach ($researchDirections as $direction)
                    <option value="{{ $direction->research_direction_id }}">{{ $direction->research_direction_name }}</option>
                @endforeach
            </select>
        </div>        
        <div class="mb-3">
            <label for="topic_name" class="form-label">Tên đề tài</label>
            <input type="text" name="topic_name" id="topic_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="research_goal" class="form-label">Mục tiêu</label>
            <textarea name="research_goal" id="research_goal" rows="3" class="form-control" ></textarea>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Nội dung</label>
            <textarea name="content" id="content" rows="4" class="form-control" ></textarea>
        </div>
        <div class="mb-3">
            <label for="lecturer_id" class="form-label">Giảng viên hướng dẫn</label>
            <select name="lecturer_id" id="lecturer_id" class="form-select" >
                <option value="">Chọn giảng viên</option>
                @foreach ($lecturers as $lecturer)
                    <option value="{{ $lecturer->lecturer_id }}">{{ $lecturer->lecturer_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Ngày bắt đầu</label>
            <input type="date" name="start_date" id="start_date" class="form-control" >
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">Ngày kết thúc</label>
            <input type="date" name="end_date" id="end_date" class="form-control" >
        </div>
        <button type="submit" class="btn btn-primary">Thêm</button>
        <a href="{{ route('research_topics.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
