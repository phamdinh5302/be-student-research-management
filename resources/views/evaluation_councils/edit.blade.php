@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Chỉnh sửa Hội đồng Nghiên cứu</h1>

    <form action="{{ route('evaluation_councils.update', $council->council_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="council_name" class="form-label">Tên hội đồng</label>
            <input type="text" name="council_name" id="council_name" class="form-control" value="{{ $council->council_name }}" required>
        </div>

        <div class="mb-3">
            <label for="council_level" class="form-label">Cấp độ hội đồng</label>
            <input type="text" name="council_level" id="council_level" class="form-control" value="{{ $council->council_level }}" required>
        </div>

        <div class="mb-3">
            <label for="time" class="form-label">Thời gian</label>
            <input type="datetime-local" name="time" id="time" class="form-control" value="{{ $council->time }}" required>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Địa điểm</label>
            <input type="text" name="location" id="location" class="form-control" value="{{ $council->location }}" required>
        </div>

        <div class="mb-3">
            <label for="lecturer_ids" class="form-label">Giảng viên tham gia</label>
            <select name="lecturer_ids[]" id="lecturer_ids" class="form-select" multiple required>
                @foreach ($lecturers as $lecturer)
                    <option value="{{ $lecturer->lecturer_id }}" {{ in_array($lecturer->lecturer_id, $council->lecturers->pluck('lecturer_id')->toArray()) ? 'selected' : '' }}>
                        {{ $lecturer->lecturer_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="topic_ids" class="form-label">Chọn đề tài</label>
            <select name="topic_ids[]" id="topic_ids" class="form-select" multiple required>
                @foreach ($topics as $topic)
                    <option value="{{ $topic->topic_id }}" {{ in_array($topic->topic_id, $council->topics->pluck('topic_id')->toArray()) ? 'selected' : '' }}>
                        {{ $topic->topic_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật hội đồng</button>
        <a href="{{ route('evaluation_councils.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
