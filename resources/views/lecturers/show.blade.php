@extends('layouts.app')

@section('content')
    <h1>Chi tiết giảng viên</h1>
    <p><strong>Mã giảng viên:</strong> {{ $lecturer->lecturer_id }}</p>
    <p><strong>Tên giảng viên:</strong> {{ $lecturer->lecturer_name }}</p>
    <p><strong>Khoa:</strong> {{ $lecturer->faculty }}</p>
    <p><strong>Học vị:</strong> {{ $lecturer->academic_degree }}</p>
    <p><strong>Số lượng đề tài:</strong> {{ $lecturer->number_of_topics }}</p>
    <p><strong>Hướng nghiên cứu:</strong> 
        {{ $lecturer->researchDirections->pluck('research_direction_name')->join(', ') }}
    </p>
    <a href="{{ route('lecturers.index') }}">Quay lại danh sách</a>
@endsection
