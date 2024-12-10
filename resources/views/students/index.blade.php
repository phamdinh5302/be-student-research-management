@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Danh sách sinh viên</h1>
    <a href="{{ route('students.create') }}" class="btn btn-primary mb-3">Thêm mới sinh viên</a>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tên sinh viên</th>
                <th>Khoa</th>
                <th>Lớp</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td>{{ $student->student_id }}</td>
                    <td>{{ $student->student_name }}</td>
                    <td>{{ $student->faculty }}</td>
                    <td>{{ $student->class }}</td>
                    <td class="action-column">
                        <a href="{{ route('students.show', $student->student_id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('students.edit', $student->student_id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('students.destroy', $student->student_id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
