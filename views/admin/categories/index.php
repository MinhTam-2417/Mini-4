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
          <h2 class="mb-1"><i class="bi bi-tags"></i> Quản lý danh mục</h2>
          <p class="text-muted mb-0">Quản lý các danh mục bài viết</p>
        </div>
        <a href="/Mini-4/public/admin/categories/create" class="btn btn-primary">
          <i class="bi bi-plus"></i> Tạo danh mục mới
        </a>
      </div>
    </div>

    <div class="content-card">
      <div class="card-body p-0">
        <table class="table table-hover mb-0">
          <thead>
            <tr>
              <th>ID</th>
              <th>Tên danh mục</th>
              <th>Slug</th>
              <th>Mô tả</th>
              <th>Ngày tạo</th>
              <th>Thao tác</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($categories)): ?>
              <?php foreach ($categories as $category): ?>
                <tr>
                  <td><?php echo $category['id']; ?></td>
                  <td>
                    <strong><?php echo htmlspecialchars($category['name']); ?></strong>
                  </td>
                  <td>
                    <code><?php echo htmlspecialchars($category['slug']); ?></code>
                  </td>
                  <td>
                    <?php if ($category['description']): ?>
                      <?php echo htmlspecialchars($category['description']); ?>
                    <?php else: ?>
                      <span class="text-muted">Không có mô tả</span>
                    <?php endif; ?>
                  </td>
                  <td><?php echo date('d/m/Y', strtotime($category['created_at'])); ?></td>
                  <td>
                    <a href="/Mini-4/public/admin/categories/<?php echo $category['id']; ?>/edit" class="btn btn-sm btn-outline-primary btn-action">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger btn-action" onclick="deleteCategory(<?php echo $category['id']; ?>)">
                      <i class="bi bi-trash"></i>
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center py-4">
                  <i class="bi bi-inbox display-4 text-muted"></i>
                  <p class="mt-2 text-muted">Chưa có danh mục nào.</p>
                  <a href="/Mini-4/public/admin/categories/create" class="btn btn-primary">
                    <i class="bi bi-plus"></i> Tạo danh mục đầu tiên
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
        function deleteCategory(categoryId) {
            if (confirm('Bạn có chắc chắn muốn xóa danh mục này?')) {
                // Tạo form để submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/Mini-4/public/admin/categories/' + categoryId + '/delete';
                
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
