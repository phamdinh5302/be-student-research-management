<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Account Management')</title>
    <!-- Thêm Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f8ff; /* Màu xanh dương nhạt */
        }
        .sidebar {
            width: 250px;
            position: fixed;
            left: 0;
            top: 60px; /* Chiều cao navbar */
            height: calc(100% - 56px);
            background-color: #0554a9; /* Sidebar màu xanh dương đậm */
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            padding: 15px;
            text-decoration: none;
            display: block;
        }
        .sidebar a:hover {
            background-color: #0056b3;
        }
        .content {
            margin-left: 250px; /* Để tránh đè lên sidebar */
            padding: 20px;
        }
        .navbar-brand {
            color: #ffffff !important;
        }
        .notification-icon {
            color: white;
            font-size: 1.2em;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">Hệ thống quản lý nghiên cứu khoa học</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell-fill notification-icon"></i> <!-- Icon thông báo -->
                            {{ Auth::user()->username }} <!-- Hiển thị tên người dùng -->
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="">Sửa thông tin cá nhân</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Đăng xuất</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar bên trái -->
    <div class="sidebar">
        <a href="{{ route('accounts.index') }}">Quản lý tài khoản</a>
        <a href="">Quản lý đề tài</a>
        <a href="">Quản lýTiến độ nghiên cứu</a>
        <a href="">Quản lý Hội đồng đánh giá</a>
        <a href="{{ route('students.index') }}">Quản lý Sinh viên</a>
        <a href="">Quản lý Giảng viên</a>
        <a href="">Quản lý Đề cương</a>
        <a href="">Quản lý Kết quả nghiên cứu</a>
    </div>

    <!-- Nội dung động của trang -->
    <div class="content">
        @yield('content')
    </div>

    <!-- Bootstrap JS và Icon -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!-- Import icons -->
</body>
</html>
