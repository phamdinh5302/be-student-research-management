@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Chi tiết Kết quả Nghiên cứu</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Đề tài: {{ $result->topic->topic_name }}</h5>
                <p class="card-text"><strong>Điểm:</strong> {{ $result->score ?? 'Chưa chấm' }}</p>
                <p class="card-text"><strong>Phản hồi:</strong> {{ $result->feedback ?? 'Không có phản hồi' }}</p>
                <p class="card-text"><strong>Mô tả kết quả:</strong> {{ $result->result_description ?? 'Không có mô tả' }}
                </p>
            </div>
            <div class="card-footer">
                <a href="{{ route('research_results.index') }}" class="btn btn-secondary">Quay lại</a>
                <a href="{{ route('research_results.edit', $result->topic_id) }}" class="btn btn-warning">Chỉnh sửa</a>
            </div>
        </div>
    </div>
@endsection
