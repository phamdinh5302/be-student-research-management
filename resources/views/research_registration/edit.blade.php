@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Chỉnh sửa Đề tài Nghiên cứu</h1>

        <form action="{{ route('research_registration.update', $topic->topic_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="research_direction_id" class="form-label">Chọn hướng nghiên cứu</label>
                <select name="research_direction_id" id="research_direction_id" class="form-select" required>
                    @foreach ($researchDirections as $direction)
                        <option value="{{ $direction->research_direction_id }}"
                            {{ $topic->research_direction_id == $direction->research_direction_id ? 'selected' : '' }}>
                            {{ $direction->research_direction_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="topic_name" class="form-label">Tên đề tài</label>
                <select name="topic_id" id="topic_id" class="form-select">
                    <option value="">Chọn đề tài</option>
                    <!-- Các đề tài sẽ được load bằng Ajax -->
                </select>
                <input type="text" name="topic_name" id="topic_name" class="form-control mt-2"
                    value="{{ $topic->topic_name }}" required>
            </div>

            <div class="mb-3">
                <label for="lecturer_id" class="form-label">Giảng viên hướng dẫn</label>
                <select name="lecturer_id" id="lecturer_id" class="form-select" required>
                    <option value="{{ $topic->lecturer->lecturer_id }}">{{ $topic->lecturer->lecturer_name }}</option>
                    {{-- @foreach ($lecturers as $lecturer)
                        <option value="{{ $lecturer->lecturer_id }}"
                            {{ $topic->lecturer_id == $lecturer->lecturer_id ? 'selected' : '' }}>
                            {{ $lecturer->lecturer_name }}
                        </option>
                    @endforeach --}}
                </select>
            </div>

            <div class="mb-3">
                <label for="leader_id" class="form-label">Trưởng nhóm</label>
                <select name="leader_id" id="leader_id" class="form-select" required>
                    <option value="">Chọn trưởng nhóm</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->student_id }}"
                            {{ $topic->students->where('pivot.is_leader', 1)->pluck('student_id')->contains($student->student_id)? 'selected': '' }}>
                            {{ $student->student_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="students" class="form-label">Thành viên nhóm</label>
                <select name="students[]" id="students" class="form-select students" multiple="multiple">
                    @foreach ($students as $student)
                        <option value="{{ $student->student_id }}"
                            {{ $topic->students->pluck('student_id')->contains($student->student_id) &&!$topic->students->where('pivot.is_leader', 1)->pluck('student_id')->contains($student->student_id)? 'selected': '' }}>
                            {{ $student->student_name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="mb-3">
                <label for="research_goal" class="form-label">Mục tiêu</label>
                <textarea name="research_goal" id="research_goal" class="form-control" rows="3" required>{{ $topic->research_goal }}</textarea>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Nội dung</label>
                <textarea name="content" id="content" class="form-control" rows="4" required>{{ $topic->content }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('research_topics.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        const baseUrl = '{{ url('/') }}';
        document.getElementById('research_direction_id').addEventListener('change', function() {
            const directionId = this.value;
            // Gửi AJAX request để lấy danh sách đề tài và giảng viên
            fetch(`${baseUrl}/api/get-topics-and-lecturers?research_direction_id=${directionId}`)
                .then(response => response.json())
                .then(data => {
                    const topicSelect = document.getElementById('topic_id');
                    const lecturerSelect = document.getElementById('lecturer_id');

                    // Xóa các tùy chọn cũ
                    topicSelect.innerHTML = '<option value="">Chọn đề tài</option>';
                    lecturerSelect.innerHTML = '<option value="">Chọn giảng viên</option>';

                    // Thêm các tùy chọn mới
                    data.topics.forEach(topic => {
                        topicSelect.innerHTML +=
                            `<option value="${topic.topic_id}">${topic.topic_name}</option>`;
                    });

                    data.lecturers.forEach(lecturer => {
                        lecturerSelect.innerHTML +=
                            `<option value="${lecturer.lecturer_id}">${lecturer.lecturer_name}</option>`;
                    });
                });
        });
        $(document).ready(function() {
            // Apply Select2 to the students select input
            $('#students').select2({
                placeholder: 'Chọn thành viên nhóm',
                allowClear: true,
                maximumSelectionLength: 3, // Allow up to 3 members
                width: '100%' // Make it span the full width
            });
        });
    </script>
@endsection
