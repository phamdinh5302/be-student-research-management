@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Thêm Tiến độ Nghiên cứu</h1>

        <form action="{{ route('research_progress.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="topic_id" class="form-label">Chọn đề tài</label>
                <select class="form-select" id="topic_id" name="topic_id" required>
                    <option value="">Chọn đề tài</option>
                    @foreach ($topics as $topic)
                        <option value="{{ $topic->topic_id }}">{{ $topic->topic_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="start_date" class="form-label">Ngày bắt đầu</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">Ngày kết thúc</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>

            <div class="mb-3">
                <label for="task_description" class="form-label">Mô tả công việc</label>
                <textarea class="form-control" id="task_description" name="task_description" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="report_content" class="form-label">Nội dung báo cáo</label>
                <textarea class="form-control" id="report_content" name="report_content" rows="4"></textarea>
            </div>
            <div class="mb-3">
                <label for="report_url" class="form-label">Link báo cáo</label>
                <input type="url" class="form-control" id="report_url" name="report_url" placeholder="Nhập đường link báo cáo">
            </div>

            <div class="mb-3">
                <label for="report_link_name" class="form-label">Tên đường link</label>
                <input type="text" class="form-control" id="report_link_name" name="report_link_name" placeholder="Nhập tên hiển thị của link">
            </div>

            
            <button type="submit" class="btn btn-primary">Lưu Tiến độ</button>
        </form>

        <a href="{{ route('research_progress.index') }}" class="btn btn-secondary mt-2">Quay lại danh sách</a>
    </div>
@endsection
