<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Chi tiết bài viết</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .avatar {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      object-fit: cover;
    }
    .comment-avatar {
      width: 36px;
      height: 36px;
    }
    .interaction-icon {
      font-size: 1.2rem;
      cursor: pointer;
      margin-right: 20px;
      color: #666;
    }
    .interaction-icon:hover {
      color: #000;
    }
    .reply-line {
      border-left: 2px solid #ccc;
      margin-left: 24px;
      padding-left: 16px;
    }
  </style>
</head>
<body>
  <div class="container py-5" style="max-width: 700px;">
    <!-- Bài viết chính -->
    <div class="d-flex mb-3">
      <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($author['name']); ?>" class="avatar me-3" alt="avatar">
      <div>
        <div class="fw-bold"><?php echo htmlspecialchars($author['name']); ?></div>
        <div class="text-muted small"><?php echo date('d/m/Y H:i', strtotime($post['created_at'])); ?></div>
      </div>
    </div>

    <div class="mb-3 fs-5">
      <?php echo nl2br(htmlspecialchars($post['content'])); ?>
    </div>

    <?php if (!empty($post['image'])): ?>
      <img src="<?php echo htmlspecialchars($post['image']); ?>" class="img-fluid rounded mb-3" alt="image">
    <?php endif; ?>

    <!-- Tương tác -->
    <div class="d-flex mb-4">
      <div class="interaction-icon"><i class="bi bi-heart"></i> <?php echo rand(100, 5000); ?></div>
      <div class="interaction-icon"><i class="bi bi-chat-left-text"></i> <?php echo count($comments); ?></div>
      <div class="interaction-icon"><i class="bi bi-share"></i></div>
    </div>

    <hr>

    <!-- Bình luận -->
    <h6 class="mb-3">Bình luận</h6>
    <?php foreach ($comments as $comment): ?>
      <div class="d-flex mb-3">
        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($comment['user_name']); ?>" class="avatar comment-avatar me-2" alt="avatar">
        <div class="flex-grow-1">
          <div class="fw-semibold"><?php echo htmlspecialchars($comment['user_name']); ?>
            <span class="text-muted small">· <?php echo date('d/m/Y H:i', strtotime($comment['created_at'])); ?></span>
          </div>
          <div><?php echo htmlspecialchars($comment['content']); ?></div>
          <div class="text-muted small mt-1"><i class="bi bi-heart me-1"></i> Thích</div>
        </div>
      </div>
    <?php endforeach; ?>

    <!-- Form bình luận -->
    <?php if (isset($_SESSION['user_id'])): ?>
      <form action="/blog-mini/public/post/<?php echo $post['id']; ?>/comment" method="POST" class="mt-4">
        <div class="mb-3">
          <textarea name="content" class="form-control" placeholder="Viết bình luận..." rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-dark rounded-pill px-4">Gửi</button>
      </form>
    <?php else: ?>
      <div class="alert alert-warning mt-4">
        Vui lòng <a href="/blog-mini/public/login">đăng nhập</a> để bình luận.
      </div>
    <?php endif; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
