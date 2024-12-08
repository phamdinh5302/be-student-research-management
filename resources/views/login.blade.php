<!-- resources/views/login.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(120deg, #0288d1, #26c6da);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        .login-container h1 {
            color: #0288d1;
            margin-bottom: 20px;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background: #0288d1;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .login-container button:hover {
            background: #0277bd;
        }

        .logo {
            width: 100px;
            margin-bottom: 20px;
        }

        .footer {
            margin-top: 15px;
            font-size: 12px;
            color: #555;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS8573rs1Jlus-lXCGYQWVJiinPV74LSHnDcg&s"
            alt="Đại học Mở Hà Nội" class="logo">
        <h1>Đăng nhập</h1>
        <form action="{{ route('login') }}" method="POST" class="col-md-6 offset-md-3">
            @csrf

            <div class="mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="Tên tài khoản" required>
            </div>

            <div class="mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
        </form>

        <div class="footer">© 2024 Đại học Mở Hà Nội</div>
    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
</body>
</html>
