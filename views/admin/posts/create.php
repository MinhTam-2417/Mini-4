<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tạo bài viết mới - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }

    .sidebar {
      height: 100vh;
      background-color: #000000;
      color: white;
      padding: 0;
      position: fixed;
      top: 0;
      left: 0;
      width: 250px;
      z-index: 1000;
      box-shadow: 2px 0 10px rgba(0,0,0,0.1);
    }

    .sidebar .nav-link {
      color: #ffffff;
      font-weight: 500;
      font-size: 1rem;
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 15px 20px;
      border-radius: 0;
      transition: all 0.3s ease;
      border-left: 3px solid transparent;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background-color: #333333;
      color: #ffffff;
      text-decoration: none;
      border-left: 3px solid #007bff;
    }

    .sidebar .logo {
      font-size: 1.5rem;
      font-weight: bold;
      text-align: center;
      margin: 20px 0;
      color: #ffffff;
      padding: 20px;
      border-bottom: 1px solid #333;
    }

    .main-content {
      margin-left: 250px;
      padding: 2rem;
      min-height: 100vh;
    }

    .page-header {
      background: white;
      padding: 1.5rem;
      border-radius: 12px;
      margin-bottom: 2rem;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .content-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      padding: 2rem;
    }

    .sidebar .bottom-links {
      position: absolute;
      bottom: 0;
      width: 100%;
      padding: 20px;
      border-top: 1px solid #333;
    }

    .sidebar .bottom-links .btn {
      width: 100%;
      margin-bottom: 10px;
      border-radius: 8px;
    }

    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
      }
      
      .sidebar.show {
        transform: translateX(0);
      }
      
      .main-content {
        margin-left: 0;
      }
    }

    .form-label {
      font-weight: 600;
      color: #333;
    }

    .form-control, .form-select {
      border-radius: 8px;
      border: 1px solid #ddd;
    }

    .form-control:focus, .form-select:focus {
      border-color: #007bff;
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="logo">⚙️ Admin Panel</div>

    <nav class="nav flex-column">
      <a href="/Mini-4/public/admin" class="nav-link">
        <i class="bi bi-speedometer2"></i> Dashboard
      </a>
      <a href="/Mini-4/public/admin/posts" class="nav-link active">
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
    </nav>

    <div class="bottom-links">
      <a href="/Mini-4/public/" class="btn btn-outline-light">
        <i class="bi bi-house"></i> Về trang chủ
      </a>
      <a href="/Mini-4/public/logout" class="btn btn-danger">
        <i class="bi bi-box-arrow-right"></i> Đăng xuất
      </a>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Hiển thị thông báo -->
    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($_SESSION['error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="page-header">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h2 class="mb-1"><i class="bi bi-plus-circle"></i> Tạo bài viết mới</h2>
          <p class="text-muted mb-0">Thêm bài viết mới vào hệ thống</p>
        </div>
        <a href="/Mini-4/public/admin/posts" class="btn btn-secondary">
          <i class="bi bi-arrow-left"></i> Quay lại
        </a>
      </div>
    </div>

    <div class="content-card">
      <form method="POST" action="/Mini-4/public/admin/posts" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-8">
            <!-- Tiêu đề -->
            <div class="mb-3">
              <label for="title" class="form-label">Tiêu đề bài viết *</label>
              <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <!-- Nội dung -->
            <div class="mb-3">
              <label for="content" class="form-label">Nội dung bài viết *</label>
              <textarea class="form-control" id="content" name="content" rows="15" required></textarea>
            </div>

            <!-- Tóm tắt -->
            <div class="mb-3">
              <label for="excerpt" class="form-label">Tóm tắt</label>
              <textarea class="form-control" id="excerpt" name="excerpt" rows="3" placeholder="Tóm tắt ngắn gọn về bài viết..."></textarea>
            </div>
          </div>

          <div class="col-md-4">
            <!-- Danh mục -->
            <div class="mb-3">
              <label for="category_id" class="form-label">Danh mục</label>
              <select class="form-select" id="category_id" name="category_id">
                <option value="">Chọn danh mục</option>
                <?php if (!empty($categories)): ?>
                  <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>">
                      <?php echo htmlspecialchars($category['name']); ?>
                    </option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </div>

            <!-- Hình ảnh đại diện -->
            <div class="mb-3">
              <label for="featured_image" class="form-label">Hình ảnh đại diện</label>
              <input type="file" class="form-control" id="featured_image" name="featured_image" accept="image/*">
              <div class="form-text">Chấp nhận: JPG, PNG, GIF, WebP</div>
            </div>

            <!-- Cách hiển thị hình ảnh -->
            <div class="mb-3">
              <label for="image_fit" class="form-label">Cách hiển thị hình ảnh</label>
              <select class="form-select" id="image_fit" name="image_fit">
                <option value="contain">Vừa khung (contain)</option>
                <option value="cover">Phủ khung (cover)</option>
                <option value="fill">Lấp đầy (fill)</option>
              </select>
            </div>

            <!-- Trạng thái -->
            <div class="mb-3">
              <label class="form-label">Trạng thái</label>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="action" id="draft" value="draft" checked>
                <label class="form-check-label" for="draft">
                  Lưu bản nháp
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="action" id="publish" value="publish">
                <label class="form-check-label" for="publish">
                  Xuất bản ngay
                </label>
              </div>
            </div>

            <!-- Nút hành động -->
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Tạo bài viết
              </button>
              <a href="/Mini-4/public/admin/posts" class="btn btn-outline-secondary">
                <i class="bi bi-x-circle"></i> Hủy bỏ
              </a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

