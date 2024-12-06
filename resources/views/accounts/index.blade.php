@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Account List</h1>
    <a href="{{ route('accounts.create') }}" class="btn btn-primary mb-3">Create New Account</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accounts as $account)
                <tr>
                    <td>{{ $account->account_id }}</td>
                    <td>{{ $account->username }}</td>
                    <td>{{ $account->email }}</td>
                    <td>{{ $account->role->role_name }}</td>
                    <td>
                        <a href="{{ route('accounts.show', $account->account_id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('accounts.edit', $account->account_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('accounts.destroy', $account->account_id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
