@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Chi tiết Hội đồng Nghiên cứu</h1>

        <div class="mb-3">
            <strong>Tên hội đồng:</strong>
            <p>{{ $council->council_name }}</p>
        </div>

        <div class="mb-3">
            <strong>Cấp độ hội đồng:</strong>
            <p>{{ $council->council_level }}</p>
        </div>

        <div class="mb-3">
            <strong>Thời gian:</strong>
            <p>{{ $council->time }}</p>
        </div>

        <div class="mb-3">
            <strong>Địa điểm:</strong>
            <p>{{ $council->location }}</p>
        </div>

        <!-- Hiển thị giảng viên theo vai trò -->
        <div class="mb-3">
            <strong>Chủ tịch hội đồng:</strong>
            <p>{{ $roles['chairman'] ? $roles['chairman']->lecturer_name : 'Chưa chọn' }}</p>
        </div>

        <div class="mb-3">
            <strong>Ủy viên:</strong>
            <p>{{ $roles['member'] ? $roles['member']->lecturer_name : 'Chưa chọn' }}</p>
        </div>

        <div class="mb-3">
            <strong>Thư ký:</strong>
            <p>{{ $roles['secretary'] ? $roles['secretary']->lecturer_name : 'Chưa chọn' }}</p>
        </div>

        <!-- Hiển thị danh sách đề tài -->
        <div class="mb-3">
            <strong>Đề tài:</strong>
            <ul>
                @foreach ($council->topics as $topic)
                    <li>{{ $topic->topic_name }}</li>
                @endforeach
            </ul>
        </div>

        <div class="mb-3">
            <a href="{{ route('evaluation_councils.index') }}" class="btn btn-secondary">Trở lại danh sách</a>
        </div>
    </div>
@endsection
