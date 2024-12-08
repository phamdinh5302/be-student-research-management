@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Danh Sách Tài Khoản</h1>
        <!-- Nút Thêm mới, Tải lại và Xuất Excel -->
        <div class="d-flex mb-3">
            <a href="{{ route('accounts.create') }}" class="btn btn-primary me-2">
                <i class="fas fa-plus"></i> Thêm mới
            </a>
            <a href="{{ route('accounts.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-sync-alt"></i> Tải lại
            </a>
            <a href="" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Xuất Excel
            </a>
        </div>

        <!-- Form tìm kiếm -->
        <form action="{{ route('accounts.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm..."
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary">Tìm kiếm</button>
            </div>
        </form>
        <!-- Bảng hiển thị danh sách tài khoản -->
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Tên Tài Khoản</th>
                    <th>CCCD</th>
                    <th>Giới Tính</th>
                    <th>Ngày Sinh</th>
                    <th>Email</th>
                    <th>Số Điện Thoại</th>
                    <th>Vai Trò</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($accounts as $account)
                    <tr>
                        <td>{{ $account->account_id }}</td>
                        <td>{{ $account->username }}</td>
                        <td>{{ $account->cccd }}</td>
                        <td>{{ $account->gender }}</td>
                        <td>{{ \Carbon\Carbon::parse($account->birth_date)->format('d/m/Y') }}</td>
                        <td>{{ $account->email }}</td>
                        <td>{{ $account->phone_number }}</td>
                        <td>{{ $account->role->role_name }}</td>
                        <td>
                            <a href="{{ route('accounts.show', $account->account_id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('accounts.edit', $account->account_id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('accounts.destroy', $account->account_id) }}" method="POST"
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

        <!-- Phân trang -->
        <div class="d-flex justify-content-center">
            {{ $accounts->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
