<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">
        <i class="bi bi-eye-slash text-warning me-2"></i>
        Bài viết đã ẩn
    </h2>
    <span class="badge bg-warning fs-6"><?php echo $total_count; ?> bài viết</span>
</div>

<!-- Posts List -->
<?php if (empty($hidden_posts)): ?>
    <div class="text-center py-5">
        <i class="bi bi-eye-slash text-muted" style="font-size: 4rem;"></i>
        <h4 class="text-muted mt-3">Bạn chưa ẩn bài viết nào</h4>
        <p class="text-muted">Các bài viết bạn ẩn sẽ xuất hiện ở đây!</p>
        <a href="/Mini-4/public/" class="btn btn-primary">
            <i class="bi bi-house-door me-2"></i>Về trang chủ
        </a>
    </div>
<?php else: ?>
    <div class="row">
        <div class="col-md-8">
            <?php foreach ($hidden_posts as $post): ?>
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <?php if (!empty($post['featured_image'])): ?>
                                <img src="/Mini-4/public/<?php echo htmlspecialchars($post['featured_image']); ?>" 
                                     class="img-fluid rounded-start h-100" style="object-fit: cover;"
                                     alt="<?php echo htmlspecialchars($post['title']); ?>">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                    <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="/Mini-4/public/post/<?php echo $post['id']; ?>" 
                                       class="text-decoration-none text-dark">
                                        <?php echo htmlspecialchars($post['title']); ?>
                                    </a>
                                </h5>
                                <p class="card-text text-muted">
                                    <?php 
                                    $excerpt = $post['excerpt'] ?? '';
                                    $content = $post['content'] ?? '';
                                    if (!empty($excerpt)) {
                                        echo htmlspecialchars($excerpt);
                                    } elseif (!empty($content)) {
                                        echo htmlspecialchars(substr($content, 0, 100) . '...');
                                    } else {
                                        echo 'Không có mô tả';
                                    }
                                    ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="bi bi-person me-1"></i>
                                        <?php echo htmlspecialchars($post['author_name'] ?? 'Không xác định'); ?>
                                        <span class="mx-2">•</span>
                                        <i class="bi bi-calendar me-1"></i>
                                        <?php echo date('d/m/Y', strtotime($post['created_at'])); ?>
                                        <span class="mx-2">•</span>
                                        <i class="bi bi-eye me-1"></i>
                                        <?php echo $post['view_count'] ?? 0; ?> lượt xem
                                        <span class="mx-2">•</span>
                                        <i class="bi bi-heart-fill text-danger me-1"></i>
                                        <?php echo $post['like_count'] ?? 0; ?> lượt thích
                                    </small>
                                </div>
                                <div class="mt-3">
                                    <button class="hide-btn btn btn-sm <?php echo isset($post['user_hidden']) && $post['user_hidden'] ? 'btn-warning' : 'btn-outline-warning'; ?>" 
                                            data-post-id="<?php echo $post['id']; ?>" 
                                            title="<?php echo isset($post['user_hidden']) && $post['user_hidden'] ? 'Hiện bài viết' : 'Ẩn bài viết'; ?>">
                                        <span class="hide-icon">
                                            <i class="bi bi-eye-slash"></i>
                                        </span>
                                    </button>
                                    <a href="/Mini-4/public/post/<?php echo $post['id']; ?>" 
                                       class="btn btn-outline-primary btn-sm">
                                        Đọc tiếp →
                                    </a>
                                </div>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>
                                    Đã ẩn lúc: <?php echo date('d/m/Y H:i', strtotime($post['hidden_at'])); ?>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <nav aria-label="Hidden posts pagination">
                    <ul class="pagination justify-content-center">
                        <?php if ($current_page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $current_page - 1; ?>">
                                    <i class="bi bi-chevron-left"></i> Trước
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo $i == $current_page ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        
                        <?php if ($current_page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $current_page + 1; ?>">
                                    Sau <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
        
        <!-- Sidebar -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-eye-slash text-warning me-2"></i>
                        Thống kê ẩn
                    </h5>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Tổng bài viết đã ẩn:</span>
                        <span class="badge bg-warning"><?php echo count($hidden_posts); ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Bài viết gần nhất:</span>
                        <small>
                            <?php echo !empty($hidden_posts) ? date('d/m/Y', strtotime($hidden_posts[0]['hidden_at'])) : 'N/A'; ?>
                        </small>
                    </div>
                    <hr>
                    <div class="text-center">
                        <a href="/Mini-4/public/" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-house-door me-1"></i>Về trang chủ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
// Xử lý nút ẩn/hiện bài viết
document.querySelectorAll('.hide-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const postId = this.dataset.postId;
        const card = this.closest('.card');
        
        if (confirm('Bạn có chắc muốn hiện bài viết này?')) {
            fetch('/Mini-4/public/hide/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `post_id=${postId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Xóa card khỏi DOM
                    card.remove();
                    
                    // Cập nhật số lượng bài viết đã ẩn
                    const badge = document.querySelector('.badge');
                    const currentCount = parseInt(badge.textContent);
                    badge.textContent = currentCount - 1;
                    
                    // Nếu không còn bài viết nào, reload trang
                    if (currentCount - 1 === 0) {
                        location.reload();
                    }
                    
                    // Hiển thị thông báo
                    showAlert(data.message, 'success');
                } else {
                    showAlert(data.message || 'Có lỗi xảy ra', 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Có lỗi xảy ra', 'danger');
            });
        }
    });
});

function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    const container = document.querySelector('.container');
    container.insertBefore(alertDiv, container.firstChild);
    
    // Tự động ẩn sau 3 giây
    setTimeout(() => {
        alertDiv.remove();
    }, 3000);
}
</script>


