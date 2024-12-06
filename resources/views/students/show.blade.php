@extends('layouts.app')

@section('content')
<h1>Student Details</h1>

<div class="card">
    <div class="card-body">
        <h3 class="card-title">{{ $student->student_name }}</h3>
        <p><strong>Account:</strong> {{ $student->account->username }}</p>
        <p><strong>Faculty:</strong> {{ $student->faculty }}</p>
        <p><strong>Class:</strong> {{ $student->class }}</p>
    </div>
</div>

<a href="{{ route('students.index') }}" class="btn btn-secondary mt-3">Back to List</a>
<a href="{{ route('students.edit', $student->student_id) }}" class="btn btn-warning mt-3">Edit</a>

<form action="{{ route('students.destroy', $student->student_id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger mt-3">Delete</button>
</form>
@endsection
