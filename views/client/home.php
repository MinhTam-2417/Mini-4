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

    .post-card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      margin-bottom: 2rem;
      overflow: hidden;
      transition: transform 0.2s;
    }

    .post-card:hover {
      transform: translateY(-2px);
    }

    .post-image {
      height: 200px;
      background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 3rem;
    }

    .post-content {
      padding: 1.5rem;
    }

    .post-title {
      font-size: 1.5rem;
      font-weight: bold;
      margin-bottom: 0.5rem;
      color: #333;
    }

    .post-excerpt {
      color: #666;
      margin-bottom: 1rem;
      line-height: 1.6;
    }

    .post-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: #999;
      font-size: 0.9rem;
    }

    .post-category {
      background: #e9ecef;
      padding: 0.25rem 0.75rem;
      border-radius: 20px;
      font-size: 0.8rem;
      color: #495057;
    }

    .read-more {
      color: #007bff;
      text-decoration: none;
      font-weight: 500;
    }

    .read-more:hover {
      color: #0056b3;
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

        <a href="/Mini-4/public/" class="nav-link"><i class="bi bi-house-door"></i> Trang chủ</a>
        <a href="#" class="nav-link"><i class="bi bi-search"></i> Tìm kiếm</a>
        <a href="#" class="nav-link"><i class="bi bi-plus-square"></i> Bài viết</a>
        <a href="#" class="nav-link"><i class="bi bi-heart"></i> Thích</a>
        <a href="/Mini-4/public/user" class="nav-link"><i class="bi bi-person"></i> Hồ sơ</a>
        <a href="#" class="nav-link"><i class="bi bi-three-dots"></i> Khác</a>
        <button id="toggle-theme" class="btn btn-outline-dark w-100 rounded-pill mb-2">
          <i class="bi bi-moon-fill me-1"></i> Chế độ tối
        </button>


        <div class="mt-auto w-100 px-3">
          <?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
          <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/Mini-4/public/logout" class="btn btn-dark w-100 rounded-pill mt-4">Đăng xuất</a>
          <?php else: ?>
            <a href="/Mini-4/public/login" class="btn btn-dark w-100 rounded-pill mt-4">Đăng nhập</a>
          <?php endif; ?>
        </div>
      </div>

      <!-- Nội dung chính -->
      <div class="col-md-7 main-content">
        <h2 class="mb-4">Bài viết mới nhất</h2>
        
        <?php if (!empty($posts)): ?>
          <?php foreach ($posts as $post): ?>
            <div class="post-card">
              <div class="post-image">
                <i class="bi bi-file-text"></i>
              </div>
              <div class="post-content">
                <h3 class="post-title">
                  <a href="/Mini-4/public/post/<?php echo $post['id']; ?>" class="text-decoration-none text-dark">
                    <?php echo htmlspecialchars($post['title']); ?>
                  </a>
                </h3>
                <p class="post-excerpt">
                  <?php echo htmlspecialchars($post['excerpt'] ?: substr($post['content'], 0, 150) . '...'); ?>
                </p>
                <div class="post-meta">
                  <div>
                    <i class="bi bi-person"></i> <?php echo htmlspecialchars($post['author_name']); ?>
                    <span class="mx-2">•</span>
                    <i class="bi bi-calendar"></i> <?php echo date('d/m/Y', strtotime($post['created_at'])); ?>
                    <?php if ($post['category_name']): ?>
                      <span class="mx-2">•</span>
                      <span class="post-category"><?php echo htmlspecialchars($post['category_name']); ?></span>
                    <?php endif; ?>
                  </div>
                  <a href="/Mini-4/public/post/<?php echo $post['id']; ?>" class="read-more">
                    Đọc tiếp <i class="bi bi-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="text-center py-5">
            <i class="bi bi-inbox display-1 text-muted"></i>
            <h3 class="mt-3">Chưa có bài viết nào</h3>
            <p class="text-muted">Hãy quay lại sau để xem các bài viết mới nhất!</p>
          </div>
        <?php endif; ?>
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
