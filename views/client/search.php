<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tìm kiếm - Blog Mini</title>
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

    .search-box {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      padding: 2rem;
      margin-bottom: 2rem;
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

    .search-highlight {
      background-color: #fff3cd;
      padding: 0.1rem 0.2rem;
      border-radius: 3px;
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
        <a href="/Mini-4/public/search" class="nav-link active"><i class="bi bi-search"></i> Tìm kiếm</a>
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
        <h2 class="mb-4"><i class="bi bi-search"></i> Tìm kiếm bài viết</h2>
        
        <!-- Form tìm kiếm -->
        <div class="search-box">
          <form method="GET" action="/Mini-4/public/search">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="q" class="form-label">Từ khóa tìm kiếm</label>
                  <input type="text" class="form-control" id="q" name="q" 
                         value="<?php echo htmlspecialchars($keyword); ?>" 
                         placeholder="Nhập từ khóa tìm kiếm..." required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label for="category" class="form-label">Danh mục</label>
                  <select class="form-select" id="category" name="category">
                    <option value="">Tất cả danh mục</option>
                    <?php foreach ($categories as $cat): ?>
                      <option value="<?php echo $cat['id']; ?>" 
                              <?php echo ($selectedCategory == $cat['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat['name']); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="mb-3">
                  <label class="form-label">&nbsp;</label>
                  <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Tìm kiếm
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>

        <!-- Kết quả tìm kiếm -->
        <?php if (!empty($keyword)): ?>
          <div class="mb-4">
            <h4>Kết quả tìm kiếm cho "<?php echo htmlspecialchars($keyword); ?>"</h4>
            <p class="text-muted">Tìm thấy <?php echo count($posts); ?> bài viết</p>
          </div>
        <?php endif; ?>
        
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
                  <?php 
                    $excerpt = $post['excerpt'] ?: substr($post['content'], 0, 200) . '...';
                    if (!empty($keyword)) {
                      $excerpt = str_ireplace($keyword, '<span class="search-highlight">' . $keyword . '</span>', $excerpt);
                    }
                    echo $excerpt;
                  ?>
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
        <?php elseif (!empty($keyword)): ?>
          <div class="text-center py-5">
            <i class="bi bi-search display-1 text-muted"></i>
            <h3 class="mt-3">Không tìm thấy kết quả</h3>
            <p class="text-muted">Thử với từ khóa khác hoặc danh mục khác</p>
          </div>
        <?php else: ?>
          <div class="text-center py-5">
            <i class="bi bi-search display-1 text-muted"></i>
            <h3 class="mt-3">Nhập từ khóa để tìm kiếm</h3>
            <p class="text-muted">Tìm kiếm trong tiêu đề, nội dung và mô tả bài viết</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 