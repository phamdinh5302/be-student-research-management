@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Tạo Hội đồng Nghiên cứu</h1>

    <form action="{{ route('evaluation_councils.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="council_name" class="form-label">Tên hội đồng</label>
            <input type="text" name="council_name" id="council_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="council_level" class="form-label">Cấp độ hội đồng</label>
            <input type="text" name="council_level" id="council_level" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="time" class="form-label">Thời gian</label>
            <input type="datetime-local" name="time" id="time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Địa điểm</label>
            <input type="text" name="location" id="location" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="lecturer_ids" class="form-label">Giảng viên tham gia</label>
            <select name="lecturer_ids[]" id="lecturer_ids" class="form-select" multiple required>
                @foreach ($lecturers as $lecturer)
                    <option value="{{ $lecturer->lecturer_id }}">{{ $lecturer->lecturer_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="topic_ids" class="form-label">Chọn đề tài</label>
            <select name="topic_ids[]" id="topic_ids" class="form-select" multiple required>
                @foreach ($topics as $topic)
                    <option value="{{ $topic->topic_id }}">{{ $topic->topic_name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Tạo hội đồng</button>
        <a href="{{ route('evaluation_councils.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
