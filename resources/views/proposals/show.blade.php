@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Chi tiết Đề cương</h1>

        <div class="mb-3">
            <strong>Tên đề tài: </strong>{{ $proposal->topic->topic_name }}
        </div>

        <div class="mb-3">
            <strong>Ngày nộp: </strong>{{ $proposal->submission_date }}
        </div>

        <div class="mb-3">
            <strong>Trạng thái phê duyệt: </strong>{{ $proposal->approval_status }}
        </div>

        <div class="mb-3">
            <strong>Nội dung đề cương: </strong>
            <p>{{ $proposal->proposal_content }}</p>
        </div>

        @if ($proposal->proposal_file)
            <div class="mb-3">
                <strong>File đính kèm:</strong> {{ basename($proposal->proposal_file) }}
                <a href="{{ asset('storage/' . $proposal->proposal_file) }}" target="_blank" class="btn btn-info btn-sm">
                    Tải về  <!-- Hiển thị tên file -->
                </a>
            </div>
        @endif

        <a href="{{ route('proposals.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
    </div>
@endsection
