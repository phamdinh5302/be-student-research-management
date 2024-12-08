@extends('layouts.app')

@section('content')
<h1 class="mb-4">Thông tin chi tiết sinh viên</h1>

<div class="card">
    <div class="card-body">
        <h3 class="card-title">{{ $student->student_name }}</h3>
        <p><strong>Tài khoản:</strong> {{ $student->account->username }}</p>
        <p><strong>Khoa:</strong> {{ $student->faculty }}</p>
        <p><strong>Lớp:</strong> {{ $student->class }}</p>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('students.index') }}" class="btn btn-secondary">Trở lại danh sách</a>
    <a href="{{ route('students.edit', $student->student_id) }}" class="btn btn-warning">Sửa</a>

    <form action="{{ route('students.destroy', $student->student_id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Xóa</button>
    </form>
</div>
@endsection
