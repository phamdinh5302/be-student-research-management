@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sửa Tài Khoản</h1>

    <form action="{{ route('accounts.update', $account->account_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="profile_picture" class="form-label">Chọn Ảnh Đại Diện</label>
            <input type="file" class="form-control" name="profile_picture">
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Tên Đăng Nhập</label>
            <input type="text" class="form-control" name="username" value="{{ $account->username }}" required>
        </div>

        <div class="mb-3">
            <label for="cccd" class="form-label">Số CCCD</label>
            <input type="text" class="form-control" name="cccd" value="{{ $account->cccd }}" required>
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label">Giới Tính</label>
            <select class="form-control" name="gender">
                <option value="Nam" {{ $account->gender == 'Nam' ? 'selected' : '' }}>Nam</option>
                <option value="Nữ" {{ $account->gender == 'Nữ' ? 'selected' : '' }}>Nữ</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="birth_date" class="form-label">Ngày Sinh</label>
            <input type="date" class="form-control" name="birth_date" value="{{ $account->birth_date }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="{{ $account->email }}" required>
        </div>

        <div class="mb-3">
            <label for="phone_number" class="form-label">Số Điện Thoại</label>
            <input type="text" class="form-control" name="phone_number" value="{{ $account->phone_number }}" required>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Địa Chỉ</label>
            <input type="text" class="form-control" name="address" value="{{ $account->address }}">
        </div>

        @if ($account->profile_picture)
            <div class="mb-3">
                <p><strong>Ảnh Đại Diện:</strong></p>
                <img src="{{ asset('storage/' . $account->profile_picture) }}" alt="Profile Picture" width="150">
            </div>
        @endif

        <div class="mb-3">
            <label for="role_id" class="form-label">Vai Trò</label>
            <select class="form-control" name="role_id">
                @foreach ($roles as $role)
                    <option value="{{ $role->role_id }}" {{ $account->role_id == $role->role_id ? 'selected' : '' }}>
                        {{ $role->role_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Cập Nhật</button>
    </form>
</div>
@endsection
