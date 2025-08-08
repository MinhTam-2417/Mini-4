<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard - Blog Mini</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }

    .sidebar {
      height: 100vh;
      background-color: #343a40;
      color: white;
      padding: 1rem 0.5rem;
      position: sticky;
      top: 0;
    }

    .sidebar .nav-link {
      color: #adb5bd;
      font-weight: 500;
      font-size: 1rem;
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 15px;
      border-radius: 8px;
      transition: all 0.2s;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background-color: #495057;
      color: white;
      text-decoration: none;
    }

    .sidebar .logo {
      font-size: 1.5rem;
      font-weight: bold;
      text-align: center;
      margin-bottom: 2rem;
      color: #fff;
    }

    .main-content {
      padding: 2rem;
    }

    .stats-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      padding: 1.5rem;
      margin-bottom: 1.5rem;
    }

    .stats-icon {
      font-size: 2.5rem;
      margin-bottom: 1rem;
    }

    .recent-item {
      border-bottom: 1px solid #eee;
      padding: 0.75rem 0;
    }

    .recent-item:last-child {
      border-bottom: none;
    }

    @media (max-width: 768px) {
      .sidebar {
        display: none;
      }
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-2 sidebar d-flex flex-column align-items-start">
        <div class="logo">⚙️ Admin</div>

        <a href="/Mini-4/public/admin" class="nav-link active">
          <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="/Mini-4/public/admin/posts" class="nav-link">
          <i class="bi bi-file-text"></i> Bài viết
        </a>
        <a href="/Mini-4/public/admin/categories" class="nav-link">
          <i class="bi bi-tags"></i> Danh mục
        </a>
        <a href="/Mini-4/public/admin/comments" class="nav-link">
          <i class="bi bi-chat-dots"></i> Bình luận
        </a>
        <a href="/Mini-4/public/admin/users" class="nav-link">
          <i class="bi bi-people"></i> Người dùng
        </a>

        <div class="mt-auto w-100 px-3">
          <a href="/Mini-4/public/" class="btn btn-outline-light w-100 rounded-pill mb-2">
            <i class="bi bi-house"></i> Về trang chủ
          </a>
          <a href="/Mini-4/public/logout" class="btn btn-danger w-100 rounded-pill">
            <i class="bi bi-box-arrow-right"></i> Đăng xuất
          </a>
        </div>
      </div>

      <!-- Main Content -->
      <div class="col-md-10 main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2><i class="bi bi-speedometer2"></i> Dashboard</h2>
          <div class="text-muted">
            Xin chào, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?>
          </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
          <div class="col-md-3">
            <div class="stats-card text-center">
              <div class="stats-icon text-primary">
                <i class="bi bi-file-text"></i>
              </div>
              <h3 class="mb-1"><?php echo $totalPosts; ?></h3>
              <p class="text-muted mb-0">Bài viết</p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stats-card text-center">
              <div class="stats-icon text-success">
                <i class="bi bi-people"></i>
              </div>
              <h3 class="mb-1"><?php echo $totalUsers; ?></h3>
              <p class="text-muted mb-0">Người dùng</p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stats-card text-center">
              <div class="stats-icon text-warning">
                <i class="bi bi-chat-dots"></i>
              </div>
              <h3 class="mb-1"><?php echo $totalComments; ?></h3>
              <p class="text-muted mb-0">Bình luận</p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stats-card text-center">
              <div class="stats-icon text-info">
                <i class="bi bi-tags"></i>
              </div>
              <h3 class="mb-1"><?php echo $totalCategories; ?></h3>
              <p class="text-muted mb-0">Danh mục</p>
            </div>
          </div>
        </div>

        <!-- Recent Content -->
        <div class="row">
          <div class="col-md-6">
            <div class="stats-card">
              <h5><i class="bi bi-file-text"></i> Bài viết gần đây</h5>
              <?php if (!empty($recentPosts)): ?>
                <?php foreach ($recentPosts as $post): ?>
                  <div class="recent-item">
                    <div class="d-flex justify-content-between">
                      <strong><?php echo htmlspecialchars($post['title']); ?></strong>
                      <small class="text-muted"><?php echo date('d/m/Y', strtotime($post['created_at'])); ?></small>
                    </div>
                    <div class="text-muted small">
                      <i class="bi bi-person"></i> <?php echo htmlspecialchars($post['author_name']); ?>
                      <?php if ($post['category_name']): ?>
                        <span class="mx-2">•</span>
                        <i class="bi bi-tag"></i> <?php echo htmlspecialchars($post['category_name']); ?>
                      <?php endif; ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <p class="text-muted">Chưa có bài viết nào.</p>
              <?php endif; ?>
            </div>
          </div>

          <div class="col-md-6">
            <div class="stats-card">
              <h5><i class="bi bi-chat-dots"></i> Bình luận gần đây</h5>
              <?php if (!empty($recentComments)): ?>
                <?php foreach ($recentComments as $comment): ?>
                  <div class="recent-item">
                    <div class="d-flex justify-content-between">
                      <strong><?php echo htmlspecialchars($comment['username']); ?></strong>
                      <small class="text-muted"><?php echo date('d/m/Y', strtotime($comment['created_at'])); ?></small>
                    </div>
                    <div class="text-muted small">
                      <?php echo htmlspecialchars(substr($comment['content'], 0, 50)) . (strlen($comment['content']) > 50 ? '...' : ''); ?>
                    </div>
                    <div class="text-muted small">
                      <i class="bi bi-file-text"></i> <?php echo htmlspecialchars($comment['post_title']); ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <p class="text-muted">Chưa có bình luận nào.</p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
