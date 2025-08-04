<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Đăng ký - Mi4</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #fafafa;
      font-family: 'Segoe UI', sans-serif;
    }

    .register-box {
      max-width: 420px;
      margin: 4rem auto;
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 16px;
      padding: 2rem;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .register-box h3 {
      font-weight: 700;
      margin-bottom: 1.5rem;
      text-align: center;
    }

    .form-control {
      border-radius: 12px;
    }

    .btn-dark {
      border-radius: 999px;
      background-color: #6c757d;
      border-color: #6c757d;
      transition: background-color 0.3s, border-color 0.3s;
    }

    .btn-dark:hover {
      background-color: #325FD7 !important;
      border-color: #325FD7 !important;
      box-shadow: 0 4px 12px rgba(25, 135, 84, 0.2);
    }

    .bottom-text {
      text-align: center;
      margin-top: 1rem;
      font-size: 0.95rem;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="register-box">
    <h3>Tạo tài khoản</h3>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger" role="alert">
        <?php echo htmlspecialchars($error); ?>
      </div>
    <?php endif; ?>

    <form action="/register" method="POST">
      <div class="mb-3">
        <label for="username" class="form-label">Tên đăng nhập</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Ví dụ: nguyenvana" required>
      </div>

      <div class="mb-3">
        <label for="full_name" class="form-label">Họ và tên</label>
        <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Nguyễn Văn A" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Địa chỉ email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="abc@gmail.com" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Mật khẩu</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>

      <div class="mb-3">
        <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
      </div>

      <button type="submit" class="btn btn-dark w-100">Đăng ký</button>

      <div class="bottom-text mt-3">
        <span>Đã có tài khoản? <a href="/login">Đăng nhập</a></span>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
