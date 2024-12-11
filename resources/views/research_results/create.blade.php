@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Thêm Kết quả Nghiên cứu</h1>
        <form action="{{ route('research_results.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="topic_id" class="form-label">Đề tài</label>
                <select class="form-control" id="topic_id" name="topic_id" required>
                    <option value="" disabled selected>-- Chọn đề tài --</option>
                    @foreach ($topics as $topic)
                        <option value="{{ $topic->topic_id }}">{{ $topic->topic_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="score" class="form-label">Điểm</label>
                <input type="number" class="form-control" id="score" name="score" step="0.1" min="0"
                    max="10">
            </div>

            <div class="mb-3">
                <label for="feedback" class="form-label">Phản hồi</label>
                <textarea class="form-control" id="feedback" name="feedback" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="result_description" class="form-label">Mô tả kết quả</label>
                <textarea class="form-control" id="result_description" name="result_description" rows="5"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="{{ route('research_results.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
@endsection
