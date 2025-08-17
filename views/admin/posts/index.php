<!-- Content --><div class="main-content">
    <!-- Debug: Hiển thị session data -->
    <div style="background: #f0f0f0; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc;">
      <strong>Debug Session:</strong><br>
      Success: <?php echo isset($_SESSION['success']) ? htmlspecialchars($_SESSION['success']) : 'Not set'; ?><br>
      Error: <?php echo isset($_SESSION['error']) ? htmlspecialchars($_SESSION['error']) : 'Not set'; ?><br>
      User ID: <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'Not set'; ?><br>
      Role: <?php echo isset($_SESSION['role']) ? $_SESSION['role'] : 'Not set'; ?>
    </div>
    
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
          <h2 class="mb-1"><i class="bi bi-file-text"></i> Quản lý bài viết</h2>
          <p class="text-muted mb-0">Quản lý tất cả bài viết trong hệ thống</p>
        </div>
        <a href="/Mini-4/public/admin/posts/create" class="btn btn-primary">
          <i class="bi bi-plus"></i> Tạo bài viết mới
        </a>
      </div>
    </div>

    <div class="content-card">
      <div class="card-body p-0">
        <table class="table table-hover mb-0">
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
                  <td>
                    <strong><?php echo htmlspecialchars($post['title']); ?></strong>
                  </td>
                  <td><?php echo htmlspecialchars($post['author_name']); ?></td>
                  <td>
                    <?php if ($post['category_name']): ?>
                      <span class="badge bg-secondary"><?php echo htmlspecialchars($post['category_name']); ?></span>
                    <?php else: ?>
                      <span class="text-muted">Không có</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <span class="badge bg-<?php echo $post['status'] === 'published' ? 'success' : 'warning'; ?>">
                      <?php echo $post['status'] === 'published' ? 'Đã xuất bản' : 'Bản nháp'; ?>
                    </span>
                  </td>
                  <td><?php echo date('d/m/Y', strtotime($post['created_at'])); ?></td>
                  <td>
                    <a href="/Mini-4/public/admin/posts/<?php echo $post['id']; ?>/edit" class="btn btn-sm btn-outline-primary btn-action">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <a href="/Mini-4/public/post/<?php echo $post['id']; ?>" class="btn btn-sm btn-outline-info btn-action" target="_blank">
                      <i class="bi bi-eye"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger btn-action" onclick="deletePost(<?php echo $post['id']; ?>)">
                      <i class="bi bi-trash"></i>
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center py-4">
                  <i class="bi bi-inbox display-4 text-muted"></i>
                  <p class="mt-2 text-muted">Chưa có bài viết nào.</p>
                  <a href="/Mini-4/public/admin/posts/create" class="btn btn-primary">
                    <i class="bi bi-plus"></i> Tạo bài viết đầu tiên
                  </a>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- JavaScript for delete functionality -->
    <script>
        function deletePost(postId) {
            if (confirm('Bạn có chắc chắn muốn xóa bài viết này?')) {
                // Tạo form để submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/Mini-4/public/admin/posts/' + postId + '/delete';
                
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
