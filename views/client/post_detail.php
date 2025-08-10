<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo htmlspecialchars($post['title']); ?> - Blog Mini</title>
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
    .post-header {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      margin-bottom: 2rem;
      overflow: hidden;
    }
    .post-image {
      width: 100%;
      max-height: 400px;
      object-fit: contain;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      background-color: #f8f9fa;
    }
    .post-content {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      margin-bottom: 2rem;
      padding: 2rem;
    }
    .comments-section {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      margin-bottom: 2rem;
    }
    .comment-form {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      margin-bottom: 2rem;
    }
    .related-posts {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .related-post-card {
      border: 1px solid #eee;
      border-radius: 8px;
      overflow: hidden;
      transition: transform 0.2s;
    }
    .related-post-card:hover {
      transform: translateY(-2px);
    }
    .related-post-image {
      width: 100%;
      height: 120px;
      object-fit: cover;
    }
    @media (max-width: 768px) {
      .sidebar {
        display: none;
      }
      .post-image {
        max-height: 250px;
      }
      .main-content {
        padding: 1rem 0.5rem;
      }
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
        <a href="#" class="nav-link"><i class="bi bi-heart"></i> Thích</a>
        <a href="/Mini-4/public/user" class="nav-link"><i class="bi bi-person"></i> Hồ sơ</a>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
          <a href="/Mini-4/public/admin" class="nav-link"><i class="bi bi-gear"></i> Admin Panel</a>
        <?php endif; ?>
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
        <!-- Header bài viết -->
        <div class="post-header">
          <div class="p-4">
            <h1 class="mb-3"><?php echo htmlspecialchars($post['title']); ?></h1>
            <div class="d-flex align-items-center text-muted mb-3">
              <i class="bi bi-person me-2"></i>
              <span><?php echo htmlspecialchars($post['author_name']); ?></span>
              <span class="mx-2">•</span>
              <i class="bi bi-calendar me-2"></i>
              <span><?php echo date('d/m/Y', strtotime($post['created_at'])); ?></span>
              <?php if ($post['category_name']): ?>
                <span class="mx-2">•</span>
                <span class="badge bg-primary"><?php echo htmlspecialchars($post['category_name']); ?></span>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Hình ảnh bài viết -->
        <?php if (!empty($post['featured_image'])): ?>
          <div class="text-center mb-4">
            <img src="/Mini-4/public/<?php echo htmlspecialchars($post['featured_image']); ?>" 
                 alt="<?php echo htmlspecialchars($post['title']); ?>" 
                 class="post-image"
                 style="object-fit: <?php echo htmlspecialchars($post['image_fit'] ?? 'contain'); ?>;">
          </div>
        <?php endif; ?>

        <!-- Nội dung bài viết -->
        <div class="post-content">
          <div class="post-excerpt mb-4">
            <p class="lead"><?php echo htmlspecialchars($post['excerpt']); ?></p>
          </div>
          <div class="post-body">
            <?php echo nl2br(htmlspecialchars($post['content'])); ?>
          </div>
        </div>

        <!-- Phần bình luận -->
        <div class="comments-section">
          <div class="p-4">
            <h4 class="mb-4">
              <i class="bi bi-chat-dots me-2"></i>
              Bình luận (<?php echo count($comments); ?>)
            </h4>
            
            <?php if (!empty($comments)): ?>
              <?php foreach ($comments as $comment): ?>
                <div class="comment mb-3 p-3 border rounded">
                  <div class="d-flex justify-content-between align-items-start">
                    <div>
                      <strong><?php echo htmlspecialchars($comment['username']); ?></strong>
                      <small class="text-muted ms-2"><?php echo date('d/m/Y H:i', strtotime($comment['created_at'])); ?></small>
                    </div>
                  </div>
                  <p class="mb-0 mt-2"><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <p class="text-muted">Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</p>
            <?php endif; ?>
          </div>
        </div>

        <!-- Form bình luận -->
        <?php if (isset($_SESSION['user_id'])): ?>
          <div class="comment-form">
            <div class="p-4">
              <h5 class="mb-3">Viết bình luận</h5>
              <form method="POST" action="/Mini-4/public/post/<?php echo $post['id']; ?>/comment">
                <div class="mb-3">
                  <textarea class="form-control" name="content" rows="4" placeholder="Viết bình luận của bạn..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-send me-2"></i>Gửi bình luận
                </button>
              </form>
            </div>
          </div>
        <?php else: ?>
          <div class="text-center p-4">
            <p class="text-muted">Bạn cần <a href="/Mini-4/public/login">đăng nhập</a> để bình luận.</p>
          </div>
        <?php endif; ?>
      </div>

      <!-- Sidebar phải -->
      <div class="col-md-3">
        <!-- Bài viết liên quan -->
        <?php if (!empty($relatedPosts)): ?>
          <div class="related-posts">
            <div class="p-4">
              <h5 class="mb-3">Bài viết liên quan</h5>
              <?php foreach ($relatedPosts as $relatedPost): ?>
                <div class="related-post-card mb-3">
                  <?php if (!empty($relatedPost['featured_image'])): ?>
                    <img src="/Mini-4/public/<?php echo htmlspecialchars($relatedPost['featured_image']); ?>" 
                         alt="<?php echo htmlspecialchars($relatedPost['title']); ?>" 
                         class="related-post-image">
                  <?php endif; ?>
                  <div class="p-3">
                    <h6 class="mb-2">
                      <a href="/Mini-4/public/post/<?php echo $relatedPost['id']; ?>" class="text-decoration-none text-dark">
                        <?php echo htmlspecialchars($relatedPost['title']); ?>
                      </a>
                    </h6>
                    <small class="text-muted">
                      <i class="bi bi-person me-1"></i><?php echo htmlspecialchars($relatedPost['author_name']); ?>
                      <span class="mx-1">•</span>
                      <i class="bi bi-calendar me-1"></i><?php echo date('d/m/Y', strtotime($relatedPost['created_at'])); ?>
                    </small>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const toggleBtn = document.getElementById('toggle-theme');
    const body = document.body;
    
    const currentTheme = localStorage.getItem('theme');
    if (currentTheme === 'dark') {
      body.classList.add('dark-mode');
      toggleBtn.innerHTML = '<i class="bi bi-sun-fill me-1"></i>Chế độ sáng';
    }
    
    toggleBtn.addEventListener('click', () => {
      body.classList.toggle('dark-mode');
      
      if (body.classList.contains('dark-mode')) {
        localStorage.setItem('theme', 'dark');
        toggleBtn.innerHTML = '<i class="bi bi-sun-fill me-1"></i>Chế độ sáng';
      } else {
        localStorage.setItem('theme', 'light');
        toggleBtn.innerHTML = '<i class="bi bi-moon-fill me-1"></i>Chế độ tối';
      }
    });
  </script>
</body>
</html>

