<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Quản lý người dùng - Admin</title>
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
          <a class="nav-link text-white" href="/Mini-4/public/admin/comments">Bình luận</a>
          <a class="nav-link text-white active" href="/Mini-4/public/admin/users">Người dùng</a>
        </nav>
        <div class="mt-auto">
          <a href="/Mini-4/public/" class="btn btn-outline-light btn-sm">Về trang chủ</a>
          <a href="/Mini-4/public/logout" class="btn btn-danger btn-sm">Đăng xuất</a>
        </div>
      </div>

      <!-- Main Content -->
      <div class="col-md-10 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2>Quản lý người dùng</h2>
        </div>

        <div class="card">
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Họ tên</th>
                  <th>Vai trò</th>
                  <th>Bio</th>
                  <th>Ngày tạo</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($users)): ?>
                  <?php foreach ($users as $user): ?>
                    <tr>
                      <td><?php echo $user['id']; ?></td>
                      <td><?php echo htmlspecialchars($user['username']); ?></td>
                      <td><?php echo htmlspecialchars($user['email']); ?></td>
                      <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                      <td>
                        <span class="badge bg-<?php echo $user['role'] === 'admin' ? 'danger' : 'primary'; ?>">
                          <?php echo $user['role'] === 'admin' ? 'Admin' : 'User'; ?>
                        </span>
                      </td>
                      <td>
                        <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                          <?php echo htmlspecialchars($user['bio'] ?? ''); ?>
                        </div>
                      </td>
                      <td><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></td>
                      <td>
                        <a href="/Mini-4/public/admin/users/<?php echo $user['id']; ?>/edit" class="btn btn-sm btn-outline-primary">
                          <i class="bi bi-pencil"></i>
                        </a>
                        <a href="/Mini-4/public/admin/users/<?php echo $user['id']; ?>" class="btn btn-sm btn-outline-info">
                          <i class="bi bi-eye"></i>
                        </a>
                        <?php if ($user['id'] != $_SESSION['user_id']): ?>
                          <button class="btn btn-sm btn-outline-danger" onclick="deleteUser(<?php echo $user['id']; ?>)">
                            <i class="bi bi-trash"></i>
                          </button>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="8" class="text-center">Chưa có người dùng nào.</td>
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
    function deleteUser(id) {
      if (confirm('Bạn có chắc muốn xóa người dùng này?')) {
        window.location.href = '/Mini-4/public/admin/users/' + id + '/delete';
      }
    }
  </script>
</body>
</html>
