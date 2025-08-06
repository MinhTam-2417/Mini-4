<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Blog Mini</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

  <style>
    body {
      background-color: #fafafa;
      font-family: 'Segoe UI', sans-serif;
    }

    .sidebar {
      height: 100vh;
      background-color: #fff;
      border-right: 1px solid #ddd;
      padding: 1rem 0.5rem;
      position: sticky;
      top: 0;
    }

    .sidebar .nav-link {
      color: #000;
      font-weight: 500;
      font-size: 1.1rem;
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 15px;
      border-radius: 10px;
      transition: background 0.2s;
    }

    .sidebar .nav-link:hover {
      background-color: #f0f0f0;
      text-decoration: none;
    }

    .sidebar .logo {
      font-size: 2rem;
      font-weight: bold;
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .main-content {
      padding: 2rem 1rem;
    }

    .right-box {
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 12px;
      padding: 1.5rem;
      margin-top: 2rem;
      text-align: center;
    }

    @media (max-width: 768px) {
      .sidebar {
        display: none;
      }
    }
    body.dark-mode {
  background-color: #121212;
  color: #e0e0e0;
}

.dark-mode .sidebar {
  background-color: #1e1e1e;
  border-color: #444;
}

.dark-mode .sidebar .nav-link {
  color: #e0e0e0;
}

.dark-mode .sidebar .nav-link:hover {
  background-color: #333;
}

.dark-mode .btn-outline-dark {
  border-color: #bbb;
  color: #eee;
}

.dark-mode .btn-outline-dark:hover {
  background-color: #eee;
  color: #000;
}

.dark-mode .btn-dark {
  background-color: #333;
  border-color: #555;
}

  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar trái -->
      <div class="col-md-2 sidebar d-flex flex-column align-items-start">
        <div class="logo">🧵</div>

        <a href="/Mini-4/views/client/home.php" class="nav-link"><i class="bi bi-house-door"></i> Trang chủ</a>
        <a href="#" class="nav-link"><i class="bi bi-search"></i> Tìm kiếm</a>
        <a href="/Mini-4/views/client/post_detail.php" class="nav-link"><i class="bi bi-plus-square"></i> Bài viết</a>
        <a href="#" class="nav-link"><i class="bi bi-heart"></i> Thích</a>
        <a href="/Mini-4/views/client/user.php" class="nav-link"><i class="bi bi-person"></i> Hồ sơ</a>
        <a href="#" class="nav-link"><i class="bi bi-three-dots"></i> Khác</a>
        <button id="toggle-theme" class="btn btn-outline-dark w-100 rounded-pill mb-2">
          <i class="bi bi-moon-fill me-1"></i> Chế độ tối
        </button>


        <div class="mt-auto w-100 px-3">
          <?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
          <?php if (isset($_SESSION['user_id'])): ?>
            <form action="/blog-mini/public/logout" method="POST">
              <button type="submit" class="btn btn-dark w-100 rounded-pill mt-4">Đăng xuất</button>
            </form>
          <?php else: ?>
            <a href="/Mini-4/views/client/login.php" class="btn btn-dark w-100 rounded-pill mt-4">Đăng nhập</a>
          <?php endif; ?>
        </div>
      </div>

      <!-- Nội dung chính -->
      <div class="col-md-7 main-content">
        <?php echo $content; ?>
      </div>

      <!-- Cột phải -->
      
    </div>
  </div>

  <script>
  const toggleBtn = document.getElementById('toggle-theme');
  const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
  const savedTheme = localStorage.getItem('theme');

  if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
    document.body.classList.add('dark-mode');
    toggleBtn.innerHTML = '<i class="bi bi-sun-fill me-1"></i> Chế độ sáng';
  }

  toggleBtn.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
    const isDark = document.body.classList.contains('dark-mode');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
    toggleBtn.innerHTML = isDark
      ? '<i class="bi bi-sun-fill me-1"></i> Chế độ sáng'
      : '<i class="bi bi-moon-fill me-1"></i> Chế độ tối';
  });
</script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
