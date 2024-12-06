@extends('layouts.app')

@section('content')
<h1>Add New Student</h1>
<form action="{{ route('students.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="account_id">Account</label>
        <select name="account_id" class="form-control">
            @foreach($accounts as $account)
                <option value="{{ $account->account_id }}">{{ $account->username }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="student_name">Name</label>
        <input type="text" name="student_name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="faculty">Faculty</label>
        <input type="text" name="faculty" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="class">Class</label>
        <input type="text" name="class" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Save</button>
</form>
@endsection
