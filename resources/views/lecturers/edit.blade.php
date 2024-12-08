@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Chỉnh sửa giảng viên</h1>
        <form action="{{ route('lecturers.update', $lecturer->lecturer_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="account_id">Tài khoản:</label>
                <select name="account_id" id="account_id" class="form-control" required>
                    @foreach ($accounts as $account)
                        <option value="{{ $account->account_id }}"
                            {{ $lecturer->account_id == $account->account_id ? 'selected' : '' }}>
                            {{ $account->username }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="lecturer_name">Tên giảng viên:</label>
                <input type="text" name="lecturer_name" id="lecturer_name" value="{{ $lecturer->lecturer_name }}"
                    class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="faculty">Khoa:</label>
                <input type="text" name="faculty" id="faculty" value="{{ $lecturer->faculty }}" class="form-control"
                    required>
            </div>

            <div class="form-group mb-3">
                <label for="academic_degree">Học vị:</label>
                <input type="text" name="academic_degree" id="academic_degree" value="{{ $lecturer->academic_degree }}"
                    class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="number_of_topics">Số lượng đề tài:</label>
                <input type="number" name="number_of_topics" id="number_of_topics" value="{{ $lecturer->number_of_topics }}"
                    class="form-control" min="0">
            </div>

            <div class="form-group mb-3">
                <label for="research_directions">Hướng nghiên cứu:</label>
                <select name="research_directions[]" id="research_directions" class="form-control" multiple>
                    @foreach ($researchDirections as $direction)
                        <option value="{{ $direction->research_direction_id }}"
                            {{ $lecturer->researchDirections->contains($direction) ? 'selected' : '' }}>
                            {{ $direction->research_direction_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('lecturers.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection
