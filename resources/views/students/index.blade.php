@extends('layouts.app')

@section('content')
<h1>Student List</h1>
<a href="{{ route('students.create') }}" class="btn btn-primary">Add New Student</a>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Faculty</th>
        <th>Class</th>
        <th>Actions</th>
    </tr>
    @foreach($students as $student)
    <tr>
        <td>{{ $student->student_id }}</td>
        <td>{{ $student->student_name }}</td>
        <td>{{ $student->faculty }}</td>
        <td>{{ $student->class }}</td>
        <td>
            <a href="{{ route('students.show', $student->student_id) }}" class="btn btn-info">View</a>
            <a href="{{ route('students.edit', $student->student_id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('students.destroy', $student->student_id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
