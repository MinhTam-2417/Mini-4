<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tạo bài viết mới - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-2 bg-dark text-white p-3">
        <h4>⚙️ Admin Panel</h4>
        <nav class="nav flex-column">
          <a class="nav-link text-white" href="/Mini-4/public/admin">Dashboard</a>
          <a class="nav-link text-white active" href="/Mini-4/public/admin/posts">Bài viết</a>
          <a class="nav-link text-white" href="/Mini-4/public/admin/categories">Danh mục</a>
          <a class="nav-link text-white" href="/Mini-4/public/admin/comments">Bình luận</a>
          <a class="nav-link text-white" href="/Mini-4/public/admin/users">Người dùng</a>
        </nav>
        <div class="mt-auto">
          <a href="/Mini-4/public/" class="btn btn-outline-light btn-sm">Về trang chủ</a>
          <a href="/Mini-4/public/logout" class="btn btn-danger btn-sm">Đăng xuất</a>
        </div>
      </div>

      <!-- Main Content -->
      <div class="col-md-10 p-4">
        <!-- Hiển thị thông báo -->
        <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
          <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2>Tạo bài viết mới</h2>
          <a href="/Mini-4/public/admin/posts" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
          </a>
        </div>

        <div class="card">
          <div class="card-body">
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
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

