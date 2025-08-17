<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tạo danh mục mới - Admin</title>
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
      <a href="/Mini-4/public/admin/posts" class="nav-link">
        <i class="bi bi-file-text"></i> Bài viết
      </a>
      <a href="/Mini-4/public/admin/categories" class="nav-link active">
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
          <h2 class="mb-1"><i class="bi bi-plus-circle"></i> Tạo danh mục mới</h2>
          <p class="text-muted mb-0">Thêm danh mục mới vào hệ thống</p>
        </div>
        <a href="/Mini-4/public/admin/categories" class="btn btn-secondary">
          <i class="bi bi-arrow-left"></i> Quay lại
        </a>
      </div>
    </div>

    <div class="content-card">
      <form method="POST" action="/Mini-4/public/admin/categories">
        <div class="row">
          <div class="col-md-8">
            <!-- Tên danh mục -->
            <div class="mb-3">
              <label for="name" class="form-label">Tên danh mục *</label>
              <input type="text" class="form-control" id="name" name="name" required>
              <div class="form-text">Tên hiển thị của danh mục</div>
            </div>

            <!-- Mô tả -->
            <div class="mb-3">
              <label for="description" class="form-label">Mô tả</label>
              <textarea class="form-control" id="description" name="description" rows="4" placeholder="Mô tả ngắn gọn về danh mục..."></textarea>
              <div class="form-text">Mô tả chi tiết về danh mục (không bắt buộc)</div>
            </div>
          </div>

          <div class="col-md-4">
            <!-- Thông tin bổ sung -->
            <div class="card">
              <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-info-circle"></i> Thông tin</h6>
              </div>
              <div class="card-body">
                <p class="small text-muted mb-2">
                  <strong>Slug:</strong> Sẽ được tạo tự động từ tên danh mục
                </p>
                <p class="small text-muted mb-2">
                  <strong>Ngày tạo:</strong> <?php echo date('d/m/Y H:i'); ?>
                </p>
                <p class="small text-muted mb-0">
                  <strong>Trạng thái:</strong> Hoạt động
                </p>
              </div>
            </div>

            <!-- Nút hành động -->
            <div class="d-grid gap-2 mt-3">
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Tạo danh mục
              </button>
              <a href="/Mini-4/public/admin/categories" class="btn btn-outline-secondary">
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




