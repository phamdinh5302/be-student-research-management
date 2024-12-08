@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tạo Tài Khoản Mới</h1>

    <form action="{{ route('accounts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="username" class="form-label">Tên Đăng Nhập</label>
            <input type="text" class="form-control" name="username" required>
        </div>

        <div class="mb-3">
            <label for="cccd" class="form-label">Số CCCD</label>
            <input type="text" class="form-control" name="cccd" required>
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label">Giới Tính</label>
            <select class="form-control" name="gender">
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="birth_date" class="form-label">Ngày Sinh</label>
            <input type="date" class="form-control" name="birth_date" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>

        <div class="mb-3">
            <label for="phone_number" class="form-label">Số Điện Thoại</label>
            <input type="text" class="form-control" name="phone_number" required>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Địa Chỉ</label>
            <input type="text" class="form-control" name="address">
        </div>

        <div class="mb-3">
            <label for="profile_picture" class="form-label">Ảnh Đại Diện</label>
            <input type="file" class="form-control" name="profile_picture">
        </div>

        <div class="mb-3">
            <label for="role_id" class="form-label">Vai Trò</label>
            <select class="form-control" name="role_id">
                @foreach($roles as $role)
                    <option value="{{ $role->role_id }}">{{ $role->role_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mật Khẩu</label>
            <input type="password" class="form-control" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary">Tạo Mới</button>
    </form>
</div>
@endsection
