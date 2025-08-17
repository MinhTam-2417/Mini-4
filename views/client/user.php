<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Trang cá nhân</title>
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

    .tab-link {
      font-weight: 500;
      color: #000;
    }

    .tab-link.active {
      border-bottom: 2px solid #000;
      color: #000;
    }

    .rounded-pill-custom {
      border-radius: 30px;
    }

    @media (max-width: 768px) {
      .sidebar {
        display: none;
      }
    }
    .main-content {
      max-width: 700px;
      margin: 0 auto;
    }

  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 sidebar d-flex flex-column align-items-start">
      <div class="logo">🧵</div>

      <a href="/Mini-4/public/" class="nav-link"><i class="bi bi-house-door"></i> Trang chủ</a>
      <a href="/Mini-4/public/search" class="nav-link"><i class="bi bi-search"></i> Tìm kiếm</a>
      <a href="/Mini-4/public/post/create" class="nav-link"><i class="bi bi-plus-square"></i> Bài viết</a>
              <a href="/Mini-4/public/likes" class="nav-link"><i class="bi bi-heart"></i> Thích</a>
      <a href="/Mini-4/public/user" class="nav-link"><i class="bi bi-person"></i> Hồ sơ</a>
      <a href="#" class="nav-link"><i class="bi bi-three-dots"></i> Khác</a>

      <div class="mt-auto w-100 px-3">
        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="/Mini-4/public/logout" class="btn btn-dark w-100 rounded-pill mt-4">Đăng xuất</a>
        <?php else: ?>
          <a href="/Mini-4/public/login" class="btn btn-dark w-100 rounded-pill mt-4">Đăng nhập</a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Nội dung trang cá nhân -->
    <div class="col-md-10 py-4">
      <div class="main-content">
        <!-- Hiển thị thông báo -->
        <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
          <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
          <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <!-- Thông tin user -->
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div class="d-flex align-items-center">
            <img src="<?= $user['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($user['full_name']) ?>" 
                 class="rounded-circle me-3" width="96" height="96" alt="avatar">
            <div>
              <h5 class="mb-0 fw-bold"><?= htmlspecialchars($user['full_name']) ?></h5>
              <div class="text-muted">@<?= htmlspecialchars($user['username']) ?></div>
              <?php if (!empty($user['bio'])): ?>
                <small class="text-muted"><?= htmlspecialchars($user['bio']) ?></small><br>
              <?php endif; ?>
              <small class="text-muted">
                <i class="bi bi-calendar"></i> Tham gia: <?= date('d/m/Y', strtotime($user['created_at'])) ?>
              </small>
            </div>
          </div>
          
          <!-- Nút chỉnh sửa cho chính user hoặc admin -->
          <?php if (isset($_SESSION['user_id']) && ($user['id'] == $_SESSION['user_id'] || (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'))): ?>
            <a href="/Mini-4/public/profile" class="btn btn-outline-secondary rounded-pill-custom">
              <i class="bi bi-pencil-square"></i> Chỉnh sửa
            </a>
          <?php endif; ?>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs mt-4" id="userTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="posts-tab" data-bs-toggle="tab" data-bs-target="#posts" type="button" role="tab">
              <i class="bi bi-file-text"></i> Bài viết (<?= count($posts) ?>)
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="comments-tab" data-bs-toggle="tab" data-bs-target="#comments" type="button" role="tab">
              <i class="bi bi-chat"></i> Bình luận (<?= count($comments) ?>)
            </button>
          </li>
        </ul>

        <!-- Tab content -->
        <div class="tab-content mt-3" id="userTabsContent">
          <!-- Tab Bài viết -->
          <div class="tab-pane fade show active" id="posts" role="tabpanel">
            <?php if (!empty($posts)): ?>
              <?php foreach ($posts as $post): ?>
                <div class="card mb-3">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                      <div class="flex-grow-1">
                        <h6 class="card-title">
                          <a href="/Mini-4/public/post/<?= $post['id'] ?>" class="text-decoration-none">
                            <?= htmlspecialchars($post['title']) ?>
                          </a>
                        </h6>
                        <p class="card-text text-muted small">
                          <?= htmlspecialchars($post['excerpt']) ?>
                        </p>
                        <div class="d-flex align-items-center text-muted small">
                          <i class="bi bi-calendar me-1"></i>
                          <?= date('d/m/Y', strtotime($post['created_at'])) ?>
                          <?php if (!empty($post['category_name'])): ?>
                            <span class="mx-2">•</span>
                            <i class="bi bi-tag me-1"></i>
                            <?= htmlspecialchars($post['category_name']) ?>
                          <?php endif; ?>
                          <span class="mx-2">•</span>
                          <i class="bi bi-eye me-1"></i>
                          <?= $post['views'] ?? 0 ?> lượt xem
                        </div>
                      </div>
                      
                      <!-- Nút chỉnh sửa/xóa cho tác giả hoặc admin -->
                      <?php if (isset($_SESSION['user_id']) && ($post['user_id'] == $_SESSION['user_id'] || (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'))): ?>
                        <div class="btn-group btn-group-sm ms-2">
                          <a href="/Mini-4/public/post/<?= $post['id'] ?>/edit" class="btn btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                          </a>
                          <button type="button" class="btn btn-outline-danger" onclick="deletePost(<?= $post['id'] ?>)">
                            <i class="bi bi-trash"></i>
                          </button>
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="text-center py-5">
                <i class="bi bi-file-text fs-1 text-muted"></i>
                <p class="text-muted mt-3">Chưa có bài viết nào</p>
                <?php if (isset($_SESSION['user_id']) && $user['id'] == $_SESSION['user_id']): ?>
                  <a href="/Mini-4/public/post/create" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tạo bài viết đầu tiên
                  </a>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>

          <!-- Tab Bình luận -->
          <div class="tab-pane fade" id="comments" role="tabpanel">
            <?php if (!empty($comments)): ?>
              <?php foreach ($comments as $comment): ?>
                <div class="card mb-3">
                  <div class="card-body">
                    <p class="card-text"><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                      <small class="text-muted">
                        <i class="bi bi-calendar me-1"></i>
                        <?= date('d/m/Y H:i', strtotime($comment['created_at'])) ?>
                      </small>
                      <a href="/Mini-4/public/post/<?= $comment['post_id'] ?>" class="btn btn-sm btn-outline-secondary">
                        Xem bài viết
                      </a>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="text-center py-5">
                <i class="bi bi-chat fs-1 text-muted"></i>
                <p class="text-muted mt-3">Chưa có bình luận nào</p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div> <!-- Kết thúc nội dung -->
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Hàm xóa bài viết
  function deletePost(postId) {
    if (confirm('Bạn có chắc chắn muốn xóa bài viết này? Hành động này không thể hoàn tác.')) {
      // Tạo form để submit POST request
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = '/Mini-4/public/post/' + postId + '/delete';
      document.body.appendChild(form);
      form.submit();
    }
  }
</script>
</body>
</html>
