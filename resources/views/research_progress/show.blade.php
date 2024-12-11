@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Chi tiết Tiến độ Nghiên cứu</h1>

        <div class="mb-3">
            <strong>Tên đề tài: </strong>{{ $progress->topic->topic_name }}
        </div>

        <div class="mb-3">
            <strong>Ngày bắt đầu: </strong>{{ $progress->start_date }}
        </div>

        <div class="mb-3">
            <strong>Ngày kết thúc: </strong>{{ $progress->end_date }}
        </div>

        <div class="mb-3">
            <strong>Mô tả công việc: </strong>
            <p>{{ $progress->task_description }}</p>
        </div>

        <div class="mb-3">
            <strong>Nội dung báo cáo: </strong>
            <p>{{ $progress->report_content }}</p>
        </div>
        <div class="mb-3">
            <strong>Link báo cáo: </strong>
            @if ($progress->report_url && $progress->report_link_name)
                <a href="{{ $progress->report_url }}" target="_blank">{{ $progress->report_link_name }}</a>
            @else
                <p>Chưa có link báo cáo</p>
            @endif
        </div>
        <div class="mb-3">
            <strong>Nhận xét: </strong>
            <p>{{ $progress->note }}</p>
        </div >
        <div class="mb-3">
            <strong>Trạng thái: </strong>{{ $progress->status }}
        </div>

        <a href="{{ route('research_progress.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
    </div>
@endsection
