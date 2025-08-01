<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fafafa;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            border: 1px solid #dbdbdb;
            border-radius: 20px;
            background-color: #fff;
            padding: 2rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }
        .login-title {
            font-weight: 700;
            font-size: 1.5rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .form-control {
            border-radius: 12px;
        }
        .btn-primary {
            width: 100%;
            border-radius: 12px;
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .register-link {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="login-card">
        <div class="login-title">Đăng nhập</div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="/Mini-4/views/client/user.php" method="POST">
            <div class="mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
            </div>
            <button type="submit" class="btn btn-primary">Đăng nhập</button>
        </form>

        <div class="register-link">
            <a href="/Mini-4/views/client/register.php">Chưa có tài khoản? <strong>Đăng ký</strong></a>
        </div>
    </div>
</div>

</body>
</html>
                