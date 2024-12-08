@extends('layouts.app')

@section('content')
<h1 class="mb-4">Thêm mới sinh viên</h1>
<form action="{{ route('students.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="account_id">Tài khoản</label>
        <select name="account_id" class="form-control" required>
            @foreach($accounts as $account)
                <option value="{{ $account->account_id }}">{{ $account->username }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="student_name">Tên sinh viên</label>
        <input type="text" name="student_name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="faculty">Khoa</label>
        <input type="text" name="faculty" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="class">Lớp</label>
        <input type="text" name="class" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Lưu</button>
    <a href="{{ route('students.index') }}" class="btn btn-secondary">Hủy</a>
</form>
@endsection
