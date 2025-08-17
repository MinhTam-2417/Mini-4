<!-- Comments Management Content --><div class="main-content">    <!-- Debug: Hiển thị session data -->
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
          <h2 class="mb-1"><i class="bi bi-chat-dots"></i> Quản lý bình luận</h2>
          <p class="text-muted mb-0">Quản lý tất cả bình luận trong hệ thống</p>
        </div>
      </div>
    </div>

    <div class="content-card">
      <div class="card-body p-0">
        <table class="table table-hover mb-0">
          <thead>
            <tr>
              <th>ID</th>
              <th>Người bình luận</th>
              <th>Nội dung</th>
              <th>Bài viết</th>
              <th>Ngày bình luận</th>
              <th>Thao tác</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($comments)): ?>
              <?php foreach ($comments as $comment): ?>
                <tr>
                  <td><?php echo $comment['id']; ?></td>
                  <td>
                    <strong><?php echo htmlspecialchars($comment['username'] ?? ''); ?></strong>
                  </td>
                  <td>
                    <div class="comment-content" title="<?php echo htmlspecialchars($comment['content'] ?? ''); ?>">
                      <?php echo htmlspecialchars($comment['content'] ?? ''); ?>
                    </div>
                  </td>
                  <td>
                    <a href="/Mini-4/public/post/<?php echo $comment['post_id'] ?? ''; ?>" target="_blank" class="text-decoration-none">
                      <?php echo htmlspecialchars($comment['post_title'] ?? ''); ?>
                    </a>
                  </td>
                  <td><?php echo date('d/m/Y H:i', strtotime($comment['created_at'] ?? 'now')); ?></td>
                  <td>
                    <a href="/Mini-4/public/post/<?php echo $comment['post_id'] ?? ''; ?>#comment-<?php echo $comment['id']; ?>" class="btn btn-sm btn-outline-info btn-action" target="_blank">
                      <i class="bi bi-eye"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger btn-action" onclick="deleteComment(<?php echo $comment['id']; ?>)">
                      <i class="bi bi-trash"></i>
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center py-4">
                  <i class="bi bi-chat-dots display-4 text-muted"></i>
                  <p class="mt-2 text-muted">Chưa có bình luận nào.</p>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- JavaScript for delete functionality -->
    <script>
        function deleteComment(commentId) {
            if (confirm('Bạn có chắc chắn muốn xóa bình luận này?')) {
                // Tạo form để submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/Mini-4/public/admin/comments/delete/' + commentId;
                
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
