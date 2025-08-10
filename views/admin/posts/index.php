<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Quản lý bài viết - Admin</title>
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

        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2>Quản lý bài viết</h2>
          <a href="/Mini-4/public/admin/posts/create" class="btn btn-primary">
            <i class="bi bi-plus"></i> Tạo bài viết mới
          </a>
        </div>

        <div class="card">
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Tiêu đề</th>
                  <th>Tác giả</th>
                  <th>Danh mục</th>
                  <th>Trạng thái</th>
                  <th>Ngày tạo</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($posts)): ?>
                  <?php foreach ($posts as $post): ?>
                    <tr>
                      <td><?php echo $post['id']; ?></td>
                      <td><?php echo htmlspecialchars($post['title']); ?></td>
                      <td><?php echo htmlspecialchars($post['author_name']); ?></td>
                      <td><?php echo htmlspecialchars($post['category_name'] ?? 'Không có'); ?></td>
                      <td>
                        <span class="badge bg-<?php echo $post['status'] === 'published' ? 'success' : 'warning'; ?>">
                          <?php echo $post['status'] === 'published' ? 'Đã xuất bản' : 'Bản nháp'; ?>
                        </span>
                      </td>
                      <td><?php echo date('d/m/Y', strtotime($post['created_at'])); ?></td>
                      <td>
                        <a href="/Mini-4/public/admin/posts/<?php echo $post['id']; ?>/edit" class="btn btn-sm btn-outline-primary">
                          <i class="bi bi-pencil"></i>
                        </a>
                        <a href="/Mini-4/public/post/<?php echo $post['id']; ?>" class="btn btn-sm btn-outline-info" target="_blank">
                          <i class="bi bi-eye"></i>
                        </a>
                        <button class="btn btn-sm btn-outline-danger" onclick="deletePost(<?php echo $post['id']; ?>)">
                          <i class="bi bi-trash"></i>
                        </button>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="7" class="text-center">Chưa có bài viết nào.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function deletePost(id) {
      if (confirm('Bạn có chắc muốn xóa bài viết này?')) {
        window.location.href = '/Mini-4/public/admin/posts/' + id + '/delete';
      }
    }
  </script>
</body>
</html>
