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
                <table class="table">
                    <thead>
                        <tr>
                            <th>Giảng viên</th>
                            <th>Chức vụ</th>
                        </tr>
                    </thead>
                    <tbody id="lecturerTable">
                        @foreach ($lecturers as $lecturer)
                            <tr>
                                <td>
                                    <input type="checkbox" name="lecturer_ids[{{ $lecturer->lecturer_id }}][id]"
                                        value="{{ $lecturer->lecturer_id }}">
                                    {{ $lecturer->lecturer_name }}
                                </td>
                                <td>
                                    <select name="lecturer_ids[{{ $lecturer->lecturer_id }}][duty]" class="form-select">
                                        <option value="Chủ tịch hội đồng">Chủ tịch hội đồng</option>
                                        <option value="Ủy viên">Ủy viên</option>
                                        <option value="Thư ký">Thư ký</option>
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
