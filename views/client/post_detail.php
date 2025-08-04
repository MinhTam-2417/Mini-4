<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo htmlspecialchars($post['title']); ?> - Blog Mini</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-2 bg-light p-3">
        <h4>🧵 Blog Mini</h4>
        <nav class="nav flex-column">
          <a class="nav-link" href="/Mini-4/public/">Trang chủ</a>
          <a class="nav-link" href="#">Tìm kiếm</a>
          <a class="nav-link" href="#">Bài viết</a>
        </nav>
      </div>

      <!-- Nội dung chính -->
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
