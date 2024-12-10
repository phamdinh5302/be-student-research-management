@extends('layouts.app')

@section('content')
    <h1>Thêm mới giảng viên</h1>
    <form action="{{ route('lecturers.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="account_id">Tài khoản:</label>
            <select name="account_id" id="account_id" class="form-control">
                @foreach ($accounts as $account)
                    @if($account->role_id === 3)
                        <option value="{{ $account->account_id }}">{{ $account->username }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="lecturer_name">Tên giảng viên:</label>
            <input type="text" name="lecturer_name" id="lecturer_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="faculty">Khoa:</label>
            <input type="text" name="faculty" id="faculty" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="academic_degree">Học vị:</label>
            <input type="text" name="academic_degree" id="academic_degree" class="form-control">
        </div>
        <div class="form-group">
            <label for="number_of_topics">Số lượng đề tài:</label>
            <input type="number" name="number_of_topics" id="number_of_topics" class="form-control" min="0">
        </div>
        <div class="form-group mb-3">
            <label for="research_directions">Hướng nghiên cứu:</label>
            <select name="research_directions[]" id="research_directions" class="form-control" multiple>
                @foreach ($researchDirections as $direction)
                    <option value="{{ $direction->research_direction_id }}">
                        {{ $direction->research_direction_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Thêm</button>
        <a href="{{ route('lecturers.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Apply Select2 to the students select input
            $('#research_directions').select2({
                placeholder: 'Chọn hướng nghiên cứu',
                allowClear: true,
                //maximumSelectionLength: 3, // Allow up to 3 members
                width: '100%' // Make it span the full width
            });
        });
    </script>
@endsection
