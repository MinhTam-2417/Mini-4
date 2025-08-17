<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - Blog Mini</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/Mini-4/public/css/style.css">
</head>
<body data-logged-in="<?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>">
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar trái -->
      <div class="col-md-2 sidebar d-flex flex-column align-items-start">
        <div class="logo">🧵</div>

        <a href="/Mini-4/public/" class="nav-link"><i class="bi bi-house-door"></i> Trang chủ</a>
        <a href="/Mini-4/public/search" class="nav-link"><i class="bi bi-search"></i> Tìm kiếm</a>
        <a href="/Mini-4/public/post/create" class="nav-link"><i class="bi bi-plus-square"></i> Bài viết</a>
        <a href="/Mini-4/public/likes" class="nav-link active"><i class="bi bi-heart-fill"></i> Thích</a>
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
        <!-- Hiển thị thông báo -->
        <?php if (isset($_SESSION['success'])): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
          <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
          <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2 class="mb-0">
            <i class="bi bi-heart-fill text-danger me-2"></i>
            <?php echo $title; ?>
          </h2>
          <span class="badge bg-primary fs-6"><?php echo count($likedPosts); ?> bài viết</span>
        </div>

                 <!-- Danh sách bài viết đã thích -->
         <?php if (empty($likedPosts)): ?>
           <div class="empty-likes">
             <i class="bi bi-heart"></i>
             <h4 class="text-muted">Bạn chưa thích bài viết nào</h4>
             <p class="text-muted">Hãy khám phá và thích những bài viết hay!</p>
             <a href="/Mini-4/public/" class="btn btn-primary">
               <i class="bi bi-house-door me-2"></i>Về trang chủ
             </a>
           </div>
        <?php else: ?>
          <?php foreach ($likedPosts as $post): ?>
            <div class="post-card">
              <?php if (!empty($post['featured_image'])): ?>
                <div class="post-image" style="background-image: url('/Mini-4/public/<?php echo htmlspecialchars($post['featured_image']); ?>'); background-size: <?php echo htmlspecialchars($post['image_fit'] ?? 'contain'); ?>; background-position: center;">
                </div>
              <?php else: ?>
                <div class="post-image">
                  <i class="bi bi-file-text"></i>
                </div>
              <?php endif; ?>
              
              <div class="post-content">
                <h3 class="post-title">
                  <a href="/Mini-4/public/post/<?php echo $post['post_id']; ?>" class="text-decoration-none text-dark">
                    <?php echo htmlspecialchars($post['title']); ?>
                  </a>
                </h3>
                <p class="post-excerpt">
                  <?php 
                  $excerpt = $post['excerpt'] ?? '';
                  $content = $post['content'] ?? '';
                  if (!empty($excerpt)) {
                      echo htmlspecialchars($excerpt);
                  } elseif (!empty($content)) {
                      echo htmlspecialchars(substr($content, 0, 150) . '...');
                  } else {
                      echo 'Không có mô tả';
                  }
                  ?>
                </p>
                <div class="post-meta">
                  <div>
                    <i class="bi bi-person"></i> <?php echo htmlspecialchars($post['author_name'] ?? 'Không xác định'); ?>
                    <span class="mx-2">•</span>
                    <i class="bi bi-calendar"></i> <?php echo date('d/m/Y', strtotime($post['post_created_at'])); ?>
                    <span class="mx-2">•</span>
                    <i class="bi bi-eye"></i> <?php echo $post['view_count'] ?? 0; ?> lượt xem
                    <span class="mx-2">•</span>
                    <span class="like-count" data-post-id="<?php echo $post['post_id']; ?>" title="Hover để xem ai đã like">
                      <i class="bi bi-heart-fill text-danger"></i> <?php echo $post['like_count'] ?? 0; ?> lượt thích
                    </span>
                  </div>
                  <div class="d-flex align-items-center gap-2">
                    <button class="like-btn btn btn-danger btn-sm liked" 
                            data-post-id="<?php echo $post['post_id']; ?>" 
                            title="Bỏ thích">
                      <i class="bi bi-heart-fill"></i>
                      <span class="ms-2">Đã thích</span>
                    </button>
                    <a href="/Mini-4/public/post/<?php echo $post['post_id']; ?>" class="btn btn-outline-primary btn-sm">
                      Đọc tiếp →
                    </a>
                  </div>
                </div>
                <div class="post-footer">
                  <small class="text-muted">
                    <i class="bi bi-clock"></i> Đã thích lúc: <?php echo date('d/m/Y H:i', strtotime($post['created_at'])); ?>
                  </small>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

             <!-- Sidebar phải -->
       <div class="col-md-3 sidebar-right">
         <div class="card like-stats-card">
           <div class="card-body">
             <h5 class="card-title">
               <i class="bi bi-heart-fill me-2"></i>
               Thống kê thích
             </h5>
             <div class="d-flex justify-content-between align-items-center mb-2">
               <span>Tổng bài viết đã thích:</span>
               <span class="badge bg-light text-dark liked-posts-count"><?php echo count($likedPosts); ?></span>
             </div>
             <div class="d-flex justify-content-between align-items-center mb-2">
               <span>Bài viết gần nhất:</span>
               <small>
                 <?php echo !empty($likedPosts) ? date('d/m/Y', strtotime($likedPosts[0]['created_at'])) : 'N/A'; ?>
               </small>
             </div>
             <hr style="border-color: rgba(255,255,255,0.3);">
             <div class="text-center">
               <a href="/Mini-4/public/" class="btn btn-light btn-sm">
                 <i class="bi bi-house-door me-1"></i>Về trang chủ
               </a>
             </div>
           </div>
         </div>
       </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/Mini-4/public/js/script.js"></script>
  <script src="/Mini-4/public/js/like.js"></script>
</body>
</html>
