<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Quản lý bình luận - Admin</title>
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
          <a class="nav-link text-white" href="/Mini-4/public/admin/posts">Bài viết</a>
          <a class="nav-link text-white" href="/Mini-4/public/admin/categories">Danh mục</a>
          <a class="nav-link text-white active" href="/Mini-4/public/admin/comments">Bình luận</a>
          <a class="nav-link text-white" href="/Mini-4/public/admin/users">Người dùng</a>
        </nav>
        <div class="mt-auto">
          <a href="/Mini-4/public/" class="btn btn-outline-light btn-sm">Về trang chủ</a>
          <a href="/Mini-4/public/logout" class="btn btn-danger btn-sm">Đăng xuất</a>
        </div>
      </div>

      <!-- Main Content -->
      <div class="col-md-10 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2>Quản lý bình luận</h2>
        </div>

        <div class="card">
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Người dùng</th>
                  <th>Bài viết</th>
                  <th>Nội dung</th>
                  <th>Trạng thái</th>
                  <th>Ngày tạo</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($comments)): ?>
                  <?php foreach ($comments as $comment): ?>
                    <tr>
                      <td><?php echo $comment['id']; ?></td>
                      <td><?php echo htmlspecialchars($comment['username']); ?></td>
                      <td><?php echo htmlspecialchars($comment['post_title']); ?></td>
                      <td>
                        <div style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                          <?php echo htmlspecialchars($comment['content']); ?>
                        </div>
                      </td>
                      <td>
                        <span class="badge bg-<?php echo $comment['status'] === 'approved' ? 'success' : ($comment['status'] === 'pending' ? 'warning' : 'danger'); ?>">
                          <?php 
                          echo $comment['status'] === 'approved' ? 'Đã duyệt' : 
                               ($comment['status'] === 'pending' ? 'Chờ duyệt' : 'Từ chối'); 
                          ?>
                        </span>
                      </td>
                      <td><?php echo date('d/m/Y', strtotime($comment['created_at'])); ?></td>
                      <td>
                        <?php if ($comment['status'] === 'pending'): ?>
                          <a href="/Mini-4/public/admin/comments/<?php echo $comment['id']; ?>/approve" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-check"></i>
                          </a>
                          <a href="/Mini-4/public/admin/comments/<?php echo $comment['id']; ?>/reject" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-x"></i>
                          </a>
                        <?php endif; ?>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteComment(<?php echo $comment['id']; ?>)">
                          <i class="bi bi-trash"></i>
                        </button>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="7" class="text-center">Chưa có bình luận nào.</td>
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
    function deleteComment(id) {
      if (confirm('Bạn có chắc muốn xóa bình luận này?')) {
        window.location.href = '/Mini-4/public/admin/comments/' + id + '/delete';
      }
    }
  </script>
</body>
</html>
