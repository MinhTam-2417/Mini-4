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

    .related-posts {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .comment-item {
      border-bottom: 1px solid #eee;
      padding: 1rem 0;
    }

    .comment-item:last-child {
      border-bottom: none;
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
      <!-- Sidebar trái -->
      <div class="col-md-2 sidebar d-flex flex-column align-items-start">
        <div class="logo">🧵</div>

        <a href="/Mini-4/public/" class="nav-link"><i class="bi bi-house-door"></i> Trang chủ</a>
        <a href="/Mini-4/public/search" class="nav-link"><i class="bi bi-search"></i> Tìm kiếm</a>
        <a href="/Mini-4/public/post/create" class="nav-link"><i class="bi bi-plus-square"></i> Bài viết</a>
        <a href="#" class="nav-link"><i class="bi bi-heart"></i> Thích</a>
        <a href="/Mini-4/public/profile" class="nav-link"><i class="bi bi-person"></i> Hồ sơ</a>
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
        <!-- Header bài viết -->
        <div class="post-header">
          <?php if (!empty($post['featured_image'])): ?>
            <img src="/Mini-4/public/<?php echo htmlspecialchars($post['featured_image']); ?>" 
                 alt="<?php echo htmlspecialchars($post['title']); ?>" 
                 class="post-image"
                 style="object-fit: <?php echo htmlspecialchars($post['image_fit'] ?? 'contain'); ?>;">
          <?php endif; ?>
          
          <div class="p-4">
            <h1 class="mb-3"><?php echo htmlspecialchars($post['title']); ?></h1>
            <div class="text-muted mb-3">
              <i class="bi bi-person"></i> <?php echo htmlspecialchars($post['author_name']); ?>
              <span class="mx-2">•</span>
              <i class="bi bi-calendar"></i> <?php echo date('d/m/Y', strtotime($post['created_at'])); ?>
              <span class="mx-2">•</span>
              <i class="bi bi-eye"></i> <?php echo $post['view_count'] ?? 0; ?> lượt xem
              <?php if ($post['category_name']): ?>
                <span class="mx-2">•</span>
                <span class="badge bg-primary"><?php echo htmlspecialchars($post['category_name']); ?></span>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Nội dung bài viết -->
        <div class="post-content">
          <div class="post-content-text">
            <?php echo nl2br(htmlspecialchars($post['content'])); ?>
          </div>
        </div>

        <!-- Phần bình luận -->
        <div class="comments-section">
          <div class="p-4">
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
                  <div class="comment-item">
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
          <div class="related-posts">
            <div class="p-4">
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
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
