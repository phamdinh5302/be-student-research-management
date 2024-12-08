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

        <div class="mb-3">
            <strong>Giảng viên tham gia:</strong>
            <ul>
                @foreach ($council->lecturers as $lecturer)
                    <li>{{ $lecturer->lecturer_name }} - {{ $lecturer->duty }}</li>
                @endforeach
            </ul>
        </div>

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
