@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Account Details</h1>

        <div class="card">
            <div class="card-body">
                <p><strong>Username:</strong> {{ $account->username }}</p>
                <p><strong>CCCD:</strong> {{ $account->cccd }}</p>
                <p><strong>Gender:</strong> {{ $account->gender }}</p>
                <p><strong>Birth Date:</strong> {{ $account->birth_date }}</p>
                <p><strong>Email:</strong> {{ $account->email }}</p>
                <p><strong>Phone Number:</strong> {{ $account->phone_number }}</p>
                <p><strong>Address:</strong> {{ $account->address }}</p>
                <p><strong>Role:</strong> {{ $account->role->role_name }}</p>
                @if ($account->profile_picture)
                    <p><strong>Profile Picture:</strong></p>
                    <img src="{{ asset('storage/' . $account->profile_picture) }}" alt="Profile Picture" width="150">
                @endif
            </div>
        </div>

        <a href="{{ route('accounts.index') }}" class="btn btn-secondary mt-3">Back</a>
    </div>
@endsection
