@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Chi Tiết Tài Khoản</h1>

        <div class="card">
            <div class="card-body">
                @if ($account->profile_picture)
                    <div class="mt-3">
                        <strong>Ảnh Đại Diện:</strong>
                        <img src="{{ asset('storage/' . $account->profile_picture) }}" alt="Profile Picture" width="150">
                    </div>
                @endif
                <p><strong>Tên Đăng Nhập:</strong> {{ $account->username }}</p>
                <p><strong>Số CCCD:</strong> {{ $account->cccd }}</p>
                <p><strong>Giới Tính:</strong> {{ $account->gender }}</p>
                <p><strong>Ngày Sinh:</strong> {{ $account->birth_date }}</p>
                <p><strong>Email:</strong> {{ $account->email }}</p>
                <p><strong>Số Điện Thoại:</strong> {{ $account->phone_number }}</p>
                <p><strong>Địa Chỉ:</strong> {{ $account->address }}</p>
                <p><strong>Vai Trò:</strong> {{ $account->role->role_name }}</p>
            </div>
        </div>

        <a href="{{ route('accounts.index') }}" class="btn btn-secondary mt-3">Quay Lại</a>
    </div>
@endsection
