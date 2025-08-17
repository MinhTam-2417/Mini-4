<!-- Content --><div class="main-content">
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

    <div class="page-header">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h2 class="mb-1"><i class="bi bi-people"></i> Quản lý người dùng</h2>
          <p class="text-muted mb-0">Quản lý tất cả người dùng trong hệ thống</p>
        </div>
      </div>
    </div>

    <div class="content-card">
      <div class="card-body p-0">
        <table class="table table-hover mb-0">
          <thead>
            <tr>
              <th>ID</th>
              <th>Username</th>
              <th>Email</th>
              <th>Vai trò</th>
              <th>Ngày tạo</th>
              <th>Thao tác</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($users)): ?>
              <?php foreach ($users as $user): ?>
                <tr>
                  <td><?php echo $user['id']; ?></td>
                  <td>
                    <strong><?php echo htmlspecialchars($user['username']); ?></strong>
                  </td>
                  <td><?php echo htmlspecialchars($user['email']); ?></td>
                  <td>
                    <span class="badge bg-<?php echo $user['role'] === 'admin' ? 'danger' : 'primary'; ?>">
                      <?php echo $user['role'] === 'admin' ? 'Admin' : 'User'; ?>
                    </span>
                  </td>
                  <td><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></td>
                  <td>
                    <a href="/Mini-4/public/user/<?php echo $user['id']; ?>" class="btn btn-sm btn-outline-info btn-action" target="_blank">
                      <i class="bi bi-eye"></i>
                    </a>
                    <?php if ($user['id'] != $_SESSION['user_id']): ?>
                      <button class="btn btn-sm btn-outline-danger btn-action" onclick="deleteUser(<?php echo $user['id']; ?>)">
                        <i class="bi bi-trash"></i>
                      </button>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center py-4">
                  <i class="bi bi-people display-4 text-muted"></i>
                  <p class="mt-2 text-muted">Chưa có người dùng nào.</p>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- JavaScript for delete functionality -->
    <script>
        function deleteUser(userId) {
            if (confirm('Bạn có chắc chắn muốn xóa người dùng này?')) {
                // Tạo form để submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/Mini-4/public/admin/users/' + userId + '/delete';
                
                // Thêm CSRF token nếu cần
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = 'csrf_token';
                csrfToken.value = '<?php echo isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : ''; ?>';
                form.appendChild(csrfToken);
                
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>

</div>
