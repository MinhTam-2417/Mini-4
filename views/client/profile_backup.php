<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Hồ sơ - Blog Mini</title>
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

    .profile-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border-radius: 15px;
      padding: 2rem;
      margin-bottom: 2rem;
      text-align: center;
    }

    .profile-avatar {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background: rgba(255,255,255,0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 3rem;
      margin: 0 auto 1rem;
    }

    .profile-card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      margin-bottom: 2rem;
      overflow: hidden;
    }

    .profile-card .card-header {
      background: #f8f9fa;
      border-bottom: 1px solid #dee2e6;
      padding: 1rem 1.5rem;
      font-weight: 600;
    }

    .profile-card .card-body {
      padding: 1.5rem;
    }

    .post-item {
      border-bottom: 1px solid #eee;
      padding: 1rem 0;
    }

    .post-item:last-child {
      border-bottom: none;
    }

    .comment-item {
      border-bottom: 1px solid #eee;
      padding: 1rem 0;
    }

    .comment-item:last-child {
      border-bottom: none;
    }

    .nav-tabs .nav-link {
      border: none;
      color: #666;
      font-weight: 500;
    }

    .nav-tabs .nav-link.active {
      color: #007bff;
      border-bottom: 2px solid #007bff;
      background: none;
    }

    .stats-item {
      text-align: center;
      padding: 1rem;
    }

    .stats-number {
      font-size: 2rem;
      font-weight: bold;
      color: #007bff;
    }

    .stats-label {
      color: #666;
      font-size: 0.9rem;
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
      <!-- Sidebar trái -->
      <div class="col-md-2 sidebar d-flex flex-column align-items-start">
        <div class="logo">🧵</div>

        <a href="/Mini-4/public/" class="nav-link"><i class="bi bi-house-door"></i> Trang chủ</a>
        <a href="/Mini-4/public/search" class="nav-link"><i class="bi bi-search"></i> Tìm kiếm</a>
        <a href="/Mini-4/public/post/create" class="nav-link"><i class="bi bi-plus-square"></i> Bài viết</a>
        <a href="/Mini-4/public/likes" class="nav-link"><i class="bi bi-heart"></i> Thích</a>
        <a href="/Mini-4/public/profile" class="nav-link active"><i class="bi bi-person"></i> Hồ sơ</a>
        <a href="#" class="nav-link"><i class="bi bi-three-dots"></i> Khác</a>

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
      <div class="col-md-10 main-content">
        <!-- Header hồ sơ -->
        <div class="profile-header">
          <div class="profile-avatar">
            <i class="bi bi-person"></i>
          </div>
          <h2><?php echo htmlspecialchars($user['full_name']); ?></h2>
          <p class="mb-0">@<?php echo htmlspecialchars($user['username']); ?></p>
          <?php if (!empty($user['bio'])): ?>
            <p class="mt-2 mb-0"><?php echo htmlspecialchars($user['bio']); ?></p>
          <?php endif; ?>
        </div>

        <!-- Thống kê -->
        <div class="row mb-4">
          <div class="col-md-4">
            <div class="stats-item">
              <div class="stats-number"><?php echo count($posts); ?></div>
              <div class="stats-label">Bài viết</div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="stats-item">
              <div class="stats-number"><?php echo count($comments); ?></div>
              <div class="stats-label">Bình luận</div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="stats-item">
              <div class="stats-number"><?php echo date('Y', strtotime($user['created_at'])); ?></div>
              <div class="stats-label">Tham gia từ</div>
            </div>
          </div>
        </div>

        <!-- Session messages -->
        <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($_SESSION['error']); ?>
          </div>
          <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
          <div class="alert alert-success" role="alert">
            <?php echo htmlspecialchars($_SESSION['success']); ?>
          </div>
          <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-4" id="profileTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">
              <i class="bi bi-person-circle"></i> Thông tin
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="posts-tab" data-bs-toggle="tab" data-bs-target="#posts" type="button" role="tab">
              <i class="bi bi-file-text"></i> Bài viết (<?php echo count($posts); ?>)
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="comments-tab" data-bs-toggle="tab" data-bs-target="#comments" type="button" role="tab">
              <i class="bi bi-chat"></i> Bình luận (<?php echo count($comments); ?>)
            </button>
          </li>
        </ul>

        <!-- Tab content -->
        <div class="tab-content" id="profileTabsContent">
          <!-- Tab thông tin -->
          <div class="tab-pane fade show active" id="info" role="tabpanel">
            <div class="row">
              <!-- Cập nhật thông tin -->
              <div class="col-md-6">
                <div class="profile-card">
                  <div class="card-header">
                    <i class="bi bi-person-gear"></i> Cập nhật thông tin
                  </div>
                  <div class="card-body">
                    <form method="POST" action="/Mini-4/public/profile/update">
                      <div class="mb-3">
                        <label for="full_name" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" 
                               value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                      </div>
                      <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?php echo htmlspecialchars($user['email']); ?>" required>
                      </div>
                      <div class="mb-3">
                        <label for="bio" class="form-label">Giới thiệu</label>
                        <textarea class="form-control" id="bio" name="bio" rows="3" 
                                  placeholder="Viết gì đó về bản thân..."><?php echo htmlspecialchars($user['bio'] ?? ''); ?></textarea>
                      </div>
                      <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Cập nhật
                      </button>
                    </form>
                  </div>
                </div>
              </div>

              <!-- Đổi mật khẩu -->
              <div class="col-md-6">
                <div class="profile-card">
                  <div class="card-header">
                    <i class="bi bi-lock"></i> Đổi mật khẩu
                  </div>
                  <div class="card-body">
                    <form method="POST" action="/Mini-4/public/profile/change-password">
                      <div class="mb-3">
                        <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                      </div>
                      <div class="mb-3">
                        <label for="new_password" class="form-label">Mật khẩu mới</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                      </div>
                      <div class="mb-3">
                        <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                      </div>
                      <button type="submit" class="btn btn-warning">
                        <i class="bi bi-key"></i> Đổi mật khẩu
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Tab bài viết -->
          <div class="tab-pane fade" id="posts" role="tabpanel">
            <div class="profile-card">
              <div class="card-header">
                <i class="bi bi-file-text"></i> Bài viết của tôi
              </div>
              <div class="card-body">
                <?php if (!empty($posts)): ?>
                  <?php foreach ($posts as $post): ?>
                    <div class="post-item">
                      <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                          <h5 class="mb-1">
                            <a href="/Mini-4/public/post/<?php echo $post['id']; ?>" class="text-decoration-none">
                              <?php echo htmlspecialchars($post['title']); ?>
                            </a>
                          </h5>
                          <p class="text-muted mb-1">
                            <small>
                              <i class="bi bi-calendar"></i> <?php echo date('d/m/Y', strtotime($post['created_at'])); ?>
                              <?php if ($post['category_name']): ?>
                                <span class="mx-2">•</span>
                                <i class="bi bi-tag"></i> <?php echo htmlspecialchars($post['category_name']); ?>
                              <?php endif; ?>
                              <span class="mx-2">•</span>
                              <i class="bi bi-eye"></i> <?php echo $post['views'] ?? 0; ?> lượt xem
                            </small>
                          </p>
                          <p class="mb-0 text-muted">
                            <?php echo substr($post['content'], 0, 150) . '...'; ?>
                          </p>
                        </div>
                        <div class="ms-3">
                          <span class="badge bg-<?php echo $post['status'] === 'published' ? 'success' : 'warning'; ?>">
                            <?php echo $post['status'] === 'published' ? 'Đã xuất bản' : 'Bản nháp'; ?>
                          </span>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <div class="text-center py-4">
                    <i class="bi bi-file-text display-4 text-muted"></i>
                    <h5 class="mt-3">Chưa có bài viết nào</h5>
                    <p class="text-muted">Bắt đầu viết bài viết đầu tiên của bạn!</p>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <!-- Tab bình luận -->
          <div class="tab-pane fade" id="comments" role="tabpanel">
            <div class="profile-card">
              <div class="card-header">
                <i class="bi bi-chat"></i> Bình luận của tôi
              </div>
              <div class="card-body">
                <?php if (!empty($comments)): ?>
                  <?php foreach ($comments as $comment): ?>
                    <div class="comment-item">
                      <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                          <p class="mb-1"><?php echo htmlspecialchars($comment['content']); ?></p>
                          <p class="text-muted mb-0">
                            <small>
                              <i class="bi bi-calendar"></i> <?php echo date('d/m/Y H:i', strtotime($comment['created_at'])); ?>
                              <span class="mx-2">•</span>
                              Trên bài viết: 
                              <a href="/Mini-4/public/post/<?php echo $comment['post_id']; ?>" class="text-decoration-none">
                                <?php echo htmlspecialchars($comment['post_title']); ?>
                              </a>
                            </small>
                          </p>
                        </div>
                        <div class="ms-3">
                          <span class="badge bg-<?php echo $comment['status'] === 'approved' ? 'success' : 'warning'; ?>">
                            <?php echo $comment['status'] === 'approved' ? 'Đã duyệt' : 'Chờ duyệt'; ?>
                          </span>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <div class="text-center py-4">
                    <i class="bi bi-chat display-4 text-muted"></i>
                    <h5 class="mt-3">Chưa có bình luận nào</h5>
                    <p class="text-muted">Bắt đầu tham gia thảo luận!</p>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 