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
                <select name="council_level" id="council_level" class="form-select" required>
                    <option value="">-- Chọn cấp độ --</option>
                    <option value="Cấp trường">Cấp trường</option>
                    <option value="Cấp khoa">Cấp khoa</option>
                </select>
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
                <label class="form-label">Chọn Chủ tịch hội đồng</label>
                <select name="lecturer_roles[chairman]" class="form-select" required>
                    <option value="">-- Chọn giảng viên --</option>
                    @foreach ($lecturers as $lecturer)
                        <option value="{{ $lecturer->lecturer_id }}">{{ $lecturer->lecturer_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Chọn Ủy viên</label>
                <select name="lecturer_roles[member]" class="form-select" required>
                    <option value="">-- Chọn giảng viên --</option>
                    @foreach ($lecturers as $lecturer)
                        <option value="{{ $lecturer->lecturer_id }}">{{ $lecturer->lecturer_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Chọn Thư ký</label>
                <select name="lecturer_roles[secretary]" class="form-select" required>
                    <option value="">-- Chọn giảng viên --</option>
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                // Apply Select2 to the students select input
                $('#topic_ids').select2({
                    placeholder: 'Chọn đề tài',
                    allowClear: true,
                    //maximumSelectionLength: 3, // Allow up to 3 members
                    width: '100%' // Make it span the full width
                });
            });
        </script>
    </div>
@endsection
