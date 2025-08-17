<div class="container mt-4 saved-posts">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-bookmark-star"></i> Bài viết đã lưu
                        <span class="badge bg-primary ms-2"><?php echo $total_count; ?></span>
                    </h4>
                </div>
                <div class="card-body">
                    <?php if (empty($saved_posts)): ?>
                        <div class="text-center py-5">
                            <i class="bi bi-bookmark-x display-1 text-muted"></i>
                            <h5 class="mt-3">Chưa có bài viết nào được lưu</h5>
                            <p class="text-muted">Hãy lưu những bài viết bạn thích để xem lại sau!</p>
                            <a href="/Mini-4/public/" class="btn btn-primary">
                                <i class="bi bi-house"></i> Về trang chủ
                            </a>
                        </div>
                    <?php else: ?>
                        <?php foreach ($saved_posts as $post): ?>
                            <div class="card mb-3">
                                <div class="row g-0">
                                    <?php if (!empty($post['featured_image'])): ?>
                                        <div class="col-md-4">
                                            <img src="/Mini-4/public/<?php echo htmlspecialchars($post['featured_image']); ?>" 
                                                 class="img-fluid rounded-start h-100" 
                                                 style="object-fit: cover; height: 200px;"
                                                 alt="<?php echo htmlspecialchars($post['title']); ?>">
                                        </div>
                                    <?php endif; ?>
                                    <div class="col-md-<?php echo !empty($post['featured_image']) ? '8' : '12'; ?>">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <a href="/Mini-4/public/post/<?php echo $post['id']; ?>" 
                                                   class="text-decoration-none">
                                                    <?php echo htmlspecialchars($post['title']); ?>
                                                </a>
                                            </h5>
                                            
                                            <?php if (!empty($post['excerpt'])): ?>
                                                <p class="card-text text-muted">
                                                    <?php echo htmlspecialchars($post['excerpt']); ?>
                                                </p>
                                            <?php endif; ?>
                                            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="small text-muted">
                                                    <i class="bi bi-person"></i> <?php echo htmlspecialchars($post['author_name']); ?>
                                                    <?php if (!empty($post['category_name'])): ?>
                                                        <span class="ms-2">
                                                            <i class="bi bi-tag"></i> <?php echo htmlspecialchars($post['category_name']); ?>
                                                        </span>
                                                    <?php endif; ?>
                                                    <span class="ms-2">
                                                        <i class="bi bi-calendar"></i> <?php echo date('d/m/Y', strtotime($post['created_at'])); ?>
                                                    </span>
                                                </div>
                                                
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-outline-danger unsave-btn" 
                                                            data-post-id="<?php echo $post['id']; ?>">
                                                        <i class="bi bi-bookmark-x"></i> Bỏ lưu
                                                    </button>
                                                    <a href="/Mini-4/public/post/<?php echo $post['id']; ?>" 
                                                       class="btn btn-sm btn-primary">
                                                        <i class="bi bi-eye"></i> Xem
                                                    </a>
                                                </div>
                                            </div>
                                            
                                            <small class="text-muted">
                                                <i class="bi bi-bookmark"></i> Đã lưu: <?php echo date('d/m/Y H:i', strtotime($post['saved_at'])); ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <!-- Pagination -->
                        <?php if ($total_pages > 1): ?>
                            <nav aria-label="Saved posts pagination">
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
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Xử lý bỏ lưu bài viết
document.querySelectorAll('.unsave-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const postId = this.dataset.postId;
        const card = this.closest('.card');
        
        if (confirm('Bạn có chắc muốn bỏ lưu bài viết này?')) {
            fetch('/Mini-4/public/post/unsave', {
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
                    
                    // Cập nhật số lượng bài viết đã lưu
                    const badge = document.querySelector('.badge');
                    const currentCount = parseInt(badge.textContent);
                    badge.textContent = currentCount - 1;
                    
                    // Nếu không còn bài viết nào, reload trang
                    if (currentCount - 1 === 0) {
                        location.reload();
                    }
                    
                    // Hiển thị thông báo
                    showAlert('Đã bỏ lưu bài viết', 'success');
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
