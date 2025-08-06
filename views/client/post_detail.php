<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo htmlspecialchars($post['title']); ?> - Blog Mini</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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
    .dark-mode .form-control {
      background-color: #1e1e1e !important;
      color: #e0e0e0 !important;
      border-color: #555 !important;
    }
    .dark-mode .form-control::placeholder{
      color: #bbb !important  ;
    }
    .dark-mode .form-control:focus {
      background-color: #2a2a2a;
      color: #fff;
      border-color: #888;
    }
    .dark-mode .btn-dark {
      background-color: #333;
      border-color: #444;
    }
    .dark-mode .btn-dark:hover {
      background-color: #444;
      color: #fff;
    }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
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
        <?php if (isset($_SESSION['user_id'])): ?>
          <form action="/blog-mini/public/logout" method="POST">
            <button type="submit" class="btn btn-dark w-100 rounded-pill mt-4">Đăng xuất</button>
          </form>
        <?php else: ?>
          <a href="/Mini-4/views/client/login.php" class="btn btn-dark w-100 rounded-pill mt-4">Đăng nhập</a>
        <?php endif; ?>
      </div>
    </div>
    <!-- Main content -->
    <div class="col-md-8 p-4">
      <!-- Header bài viết -->
      <div class="card mb-4">
        <div class="card-body">
          <h1 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h1>
          <div class="text-muted mb-3">
            <i class="bi bi-person"></i> <?php echo htmlspecialchars($post['author_name']); ?>
            <span class="mx-2">•</span>
            <i class="bi bi-calendar"></i> <?php echo date('d/m/Y', strtotime($post['created_at'])); ?>
            <span class="mx-2">•</span>
            <i class="bi bi-eye"></i> <?php echo $post['view_count']; ?> lượt xem
            <?php if ($post['category_name']): ?>
              <span class="mx-2">•</span>
              <span class="badge bg-primary"><?php echo htmlspecialchars($post['category_name']); ?></span>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <!-- Nội dung bài viết -->
      <div class="card mb-4">
        <div class="card-body">
          <div class="post-content">
            <?php echo nl2br(htmlspecialchars($post['content'])); ?>
          </div>
        </div>
      </div>
      <!-- Phần bình luận -->
      <div class="card mb-4">
        <div class="card-body">
          <h5><i class="bi bi-chat-dots"></i> Bình luận (<?php echo count($comments); ?>)</h5>
          <?php if (isset($_SESSION['user_id'])): ?>
            <form action="/Mini-4/public/post/<?php echo $post['id']; ?>/comment" method="POST" class="mb-4">
              <div class="mb-3">
                <textarea class="form-control" name="content" rows="3" placeholder="Viết bình luận của bạn..." required></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Gửi bình luận</button>
            </form>
          <?php else: ?>
            <div class="alert alert-info">
              <a href="/Mini-4/public/login">Đăng nhập</a> để bình luận
            </div>
          <?php endif; ?>
          <div class="comments-list">
            <?php if (!empty($comments)): ?>
              <?php foreach ($comments as $comment): ?>
                <div class="border-bottom pb-3 mb-3">
                  <div class="d-flex justify-content-between">
                    <strong><?php echo htmlspecialchars($comment['username']); ?></strong>
                    <small class="text-muted"><?php echo date('d/m/Y H:i', strtotime($comment['created_at'])); ?></small>
                  </div>
                  <div class="mt-2">
                    <?php echo nl2br(htmlspecialchars($comment['content'])); ?>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <p class="text-muted">Chưa có bình luận nào.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <!-- Bài viết liên quan -->
      <?php if (!empty($relatedPosts)): ?>
        <div class="card">
          <div class="card-body">
            <h5><i class="bi bi-link-45deg"></i> Bài viết liên quan</h5>
            <?php foreach ($relatedPosts as $relatedPost): ?>
              <div class="border-bottom pb-2 mb-2">
                <a href="/Mini-4/public/post/<?php echo $relatedPost['id']; ?>" class="text-decoration-none">
                  <strong><?php echo htmlspecialchars($relatedPost['title']); ?></strong>
                </a>
                <div class="text-muted small">
                  <i class="bi bi-person"></i> <?php echo htmlspecialchars($relatedPost['author_name']); ?>
                  <span class="mx-2">•</span>
                  <i class="bi bi-calendar"></i> <?php echo date('d/m/Y', strtotime($relatedPost['created_at'])); ?>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
    <!-- Cột phải -->
    <div class="col-md-2">
      <div class="card">
        <div class="card-body text-center">
          <h6>Đăng nhập</h6>
          <p class="text-muted small">Tham gia cuộc trò chuyện</p>
          <a href="/Mini-4/public/login" class="btn btn-outline-primary btn-sm">Đăng nhập</a>
        </div>
      </div>
    </div>
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