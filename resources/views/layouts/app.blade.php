<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản lý nghiên cứu khoa học của sinh viên')</title>
    <!-- Thêm Bootstrap CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>

    <style>
        body {
            background-color: #ffffff;
            /* Màu nền xanh dương nhạt */
            margin: 0;
            padding: 0;
        }

        .sidebar {
            width: 250px;
            position: fixed;
            top: 66px;
            /* Chiều cao navbar */
            left: 0;
            height: calc(100% - 60px);
            /* Sidebar sẽ dài suốt trang */
            background-color: #0554a9;
            /* Sidebar màu xanh dương đậm */
            padding-top: 20px;
            z-index: 1000;
            /* Đảm bảo sidebar luôn ở trên */
        }

        .sidebar a {
            color: white;
            padding: 15px;
            text-decoration: none;
            display: block;
            font-weight: 500;
            /* Cải thiện độ đậm của font chữ */
        }

        .sidebar a:hover {
            background-color: #003d73;
            /* Thay đổi màu hover cho phù hợp */
            color: #ffffff;
            /* Đảm bảo chữ vẫn rõ khi hover */
        }

        .sidebar a.active {
            background-color: #003d73;
            /* Màu nền cho phần tử đang active */
            color: #ffeb3b;
            /* Màu chữ cho phần tử active */
        }

        .content {
            margin-left: 250px;
            /* Để tránh đè lên sidebar */
            padding: 20px;
            overflow-y: auto;
            /* Cho phép cuộn nội dung */
            height: 100vh;
            /* Đảm bảo phần nội dung chiếm toàn bộ chiều cao */
        }

        .navbar-brand {
            color: #ffffff !important;
            font-weight: 700;
            /* Để tên thương hiệu nổi bật hơn */
            /* background-color: white; */
            /* Thêm nền trắng cho logo */
        }

        .navbar-brand img {
            background-color: white;
        }

        .navbar {
            background-color: #004b8d;
            /* Chỉnh màu navbar để đẹp hơn */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 999;
            /* Đảm bảo navbar luôn ở trên */
        }

        .navbar-nav .nav-link {
            color: #ffffff !important;
            font-weight: 500;
        }

        .navbar-nav .nav-link:hover {
            color: #ffeb3b !important;
            /* Chỉnh màu chữ khi hover */
            text-decoration: underline;
            /* Thêm gạch dưới khi hover */
        }

        .notification-icon {
            color: white;
            font-size: 1.2em;
            margin-right: 10px;
        }

        .content {
            margin-top: 60px;
            /* Để tránh đè lên navbar */
        }

        .navbar-toggler-icon {
            color: white;
            /* Đảm bảo biểu tượng hamburger có màu trắng khi thu gọn */
        }

        .dropdown-item {
            color: #333 !important;
            /* Đảm bảo văn bản trong dropdown rõ ràng */
        }

        .dropdown-item:hover {
            background-color: #f0f8ff;
            /* Màu nền của item khi hover */
            color: #000;
            /* Đảm bảo màu chữ sáng */
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="https://vnur.vn/wp-content/uploads/2023/01/63.Mo-Ha-Noi.png" alt="Logo" width="40"
                    height="40" class="me-2">
                Hệ thống quản lý nghiên cứu khoa học
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
    @if (auth()->check() && auth()->user()->role_id == 1)
        <div class="sidebar">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Trang chủ</a>
            <a href="{{ route('accounts.index') }}"
                class="{{ request()->routeIs('accounts.index') ? 'active' : '' }}">Quản lý tài khoản</a>
            <a href="{{ route('research_topics.index') }}"
                class="{{ request()->routeIs('research_topics.index') ? 'active' : '' }}">Quản lý đề tài</a>
            <a href="{{ route('research_progress.index') }}"
                class="{{ request()->routeIs('research_progress.index') ? 'active' : '' }}">Quản lý Tiến
                độ nghiên cứu</a>
            <a href="{{ route('evaluation_councils.index') }}"
                class="{{ request()->routeIs('evaluation_councils.index') ? 'active' : '' }}">Quản lý Hội đồng đánh
                giá</a>
            <a href="{{ route('students.index') }}"
                class="{{ request()->routeIs('students.index') ? 'active' : '' }}">Quản lý Sinh viên</a>
            <a href="{{ route('lecturers.index') }}"
                class="{{ request()->routeIs('lecturers.index') ? 'active' : '' }}">Quản lý Giảng viên</a>
            <a href="{{ route('proposals.index') }}"
                class="{{ request()->routeIs('proposals.index') ? 'active' : '' }}">Quản lý Đề
                cương</a>
            <a href="" class="{{ request()->routeIs('research.results.index') ? 'active' : '' }}">Quản lý Kết
                quả nghiên cứu</a>
        </div>
    @else
        <div class="sidebar">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Trang chủ</a>
            <a href="{{ route('research_registration.index') }}"
                class="{{ request()->routeIs('research_registration.index') ? 'active' : '' }}">
                Đăng ký đề tài
            </a>
            <a href="{{ route('research_progress.index') }}"
                class="{{ request()->routeIs('research_progress.index') ? 'active' : '' }}">Quản lý Tiến
                độ nghiên cứu</a>
        </div>
    @endif



    <!-- Nội dung động của trang -->
    <div class="content">
        @yield('content')
    </div>

    <!-- Bootstrap JS và Icon -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Import icons -->
</body>

</html>
