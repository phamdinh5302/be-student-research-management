@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Chỉnh sửa Hội đồng Nghiên cứu</h1>

        <form action="{{ route('evaluation_councils.update', $council->council_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="council_name" class="form-label">Tên hội đồng</label>
                <input type="text" name="council_name" id="council_name" class="form-control"
                    value="{{ $council->council_name }}" required>
            </div>

            <div class="mb-3">
                <label for="council_level" class="form-label">Cấp độ hội đồng</label>
                <select name="council_level" id="council_level" class="form-select" required>
                    <option value="Cấp trường"
                        {{ old('council_level', $council->council_level) == 'Cấp trường' ? 'selected' : '' }}>Cấp trường
                    </option>
                    <option value="Cấp khoa"
                        {{ old('council_level', $council->council_level) == 'Cấp khoa' ? 'selected' : '' }}>Cấp khoa
                    </option>
                </select>
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
                <input type="datetime-local" name="time" id="time" class="form-control" value="{{ $council->time }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Địa điểm</label>
                <input type="text" name="location" id="location" class="form-control" value="{{ $council->location }}"
                    required>
            </div>

            <!-- Chọn giảng viên theo vai trò -->
            <div class="mb-3">
                <label for="chairman" class="form-label">Chọn Chủ tịch hội đồng</label>
                <select name="lecturer_roles[chairman]" id="chairman" class="form-select" required>
                    <option value="">-- Chọn giảng viên --</option>
                    @foreach ($lecturers as $lecturer)
                        <option value="{{ $lecturer->lecturer_id }}"
                            {{ $roles['chairman'] && $roles['chairman']->lecturer_id == $lecturer->lecturer_id ? 'selected' : '' }}>
                            {{ $lecturer->lecturer_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="member" class="form-label">Chọn Ủy viên</label>
                <select name="lecturer_roles[member]" id="member" class="form-select" required>
                    <option value="">-- Chọn giảng viên --</option>
                    @foreach ($lecturers as $lecturer)
                        <option value="{{ $lecturer->lecturer_id }}"
                            {{ $roles['member'] && $roles['member']->lecturer_id == $lecturer->lecturer_id ? 'selected' : '' }}>
                            {{ $lecturer->lecturer_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="secretary" class="form-label">Chọn Thư ký</label>
                <select name="lecturer_roles[secretary]" id="secretary" class="form-select" required>
                    <option value="">-- Chọn giảng viên --</option>
                    @foreach ($lecturers as $lecturer)
                        <option value="{{ $lecturer->lecturer_id }}"
                            {{ $roles['secretary'] && $roles['secretary']->lecturer_id == $lecturer->lecturer_id ? 'selected' : '' }}>
                            {{ $lecturer->lecturer_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Chọn đề tài -->
            <div class="mb-3">
                <label for="topic_ids" class="form-label">Chọn đề tài</label>
                <select name="topic_ids[]" id="topic_ids" class="form-select" multiple required>
                    @foreach ($topics as $topic)
                        <option value="{{ $topic->topic_id }}"
                            {{ in_array($topic->topic_id, $council->topics->pluck('topic_id')->toArray()) ? 'selected' : '' }}>
                            {{ $topic->topic_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật hội đồng</button>
            <a href="{{ route('evaluation_councils.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
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
@endsection
