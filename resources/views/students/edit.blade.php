@extends('layouts.app')

@section('content')
<h1 class="mb-4">Sửa thông tin sinh viên</h1>
<form action="{{ route('students.update', $student->student_id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="account_id">Tài khoản</label>
        <select name="account_id" class="form-control" required>
            @foreach($accounts as $account)
                <option value="{{ $account->account_id }}" {{ $student->account_id == $account->account_id ? 'selected' : '' }}>
                    {{ $account->username }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="student_name">Tên sinh viên</label>
        <input type="text" name="student_name" class="form-control" value="{{ $student->student_name }}" required>
    </div>

    <div class="form-group">
        <label for="faculty">Khoa</label>
        <input type="text" name="faculty" class="form-control" value="{{ $student->faculty }}" required>
    </div>

    <div class="form-group">
        <label for="class">Lớp</label>
        <input type="text" name="class" class="form-control" value="{{ $student->class }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật</button>
    <a href="{{ route('students.index') }}" class="btn btn-secondary">Hủy</a>
</form>
@endsection
