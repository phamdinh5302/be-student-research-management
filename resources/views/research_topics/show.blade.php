@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Chi tiết Đề tài Nghiên cứu</h1>
    <div class="mb-3">
        <strong>Tên đề tài:</strong>
        <p>{{ $topic->topic_name }}</p>
    </div>
    <div class="mb-3">
        <strong>Mục tiêu:</strong>
        <p>{{ $topic->research_goal }}</p>
    </div>
    <div class="mb-3">
        <strong>Nội dung:</strong>
        <p>{{ $topic->content }}</p>
    </div>
    <div class="mb-3">
        <strong>Giảng viên hướng dẫn:</strong>
        <p>{{ $topic->lecturer->lecturer_name ?? 'Không có' }}</p>
    </div>
    <div class="mb-3">
        <strong>Ngày bắt đầu:</strong>
        <p>{{ $topic->start_date }}</p>
    </div>
    <div class="mb-3">
        <strong>Ngày kết thúc:</strong>
        <p>{{ $topic->end_date }}</p>
    </div>
    <div class="mb-3">
        <strong>Sinh viên tham gia:</strong>
        <p>{{ $topic->students->pluck('student_name')->join(', ') ?: 'Chưa có sinh viên' }}</p>
    </div>
    <a href="{{ route('research_topics.index') }}" class="btn btn-secondary">Quay lại</a>
</div>
@endsection
