<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">
        <i class="bi bi-heart-fill text-danger me-2"></i>
        Bài viết đã thích
    </h2>
    <span class="badge bg-primary fs-6"><?php echo count($likedPosts); ?> bài viết</span>
</div>

<!-- Posts List -->
<?php if (empty($likedPosts)): ?>
    <div class="text-center py-5">
        <i class="bi bi-heart text-muted" style="font-size: 4rem;"></i>
        <h4 class="text-muted mt-3">Bạn chưa thích bài viết nào</h4>
        <p class="text-muted">Hãy khám phá và thích những bài viết hay!</p>
        <a href="/Mini-4/public/" class="btn btn-primary">
            <i class="bi bi-house-door me-2"></i>Về trang chủ
        </a>
    </div>
<?php else: ?>
    <div class="row">
        <div class="col-md-8">
            <?php foreach ($likedPosts as $post): ?>
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
                                    <a href="/Mini-4/public/post/<?php echo $post['post_id']; ?>" 
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
                                        <?php echo date('d/m/Y', strtotime($post['post_created_at'])); ?>
                                        <span class="mx-2">•</span>
                                        <i class="bi bi-eye me-1"></i>
                                        <?php echo $post['view_count'] ?? 0; ?> lượt xem
                                        <span class="mx-2">•</span>
                                        <i class="bi bi-heart-fill text-danger me-1"></i>
                                        <?php echo $post['like_count'] ?? 0; ?> lượt thích
                                    </small>
                                </div>
                                <div class="mt-3">
                                    <button class="like-btn btn btn-sm <?php echo isset($post['user_liked']) && $post['user_liked'] ? 'btn-danger liked' : 'btn-outline-danger'; ?>" 
                                            data-post-id="<?php echo $post['post_id']; ?>" 
                                            title="<?php echo isset($post['user_liked']) && $post['user_liked'] ? 'Bỏ thích' : 'Thích'; ?>">
                                        <span class="like-icon">
                                            <i class="bi bi-heart<?php echo isset($post['user_liked']) && $post['user_liked'] ? '-fill' : ''; ?>"></i>
                                        </span>
                                    </button>
                                    <a href="/Mini-4/public/post/<?php echo $post['post_id']; ?>" 
                                       class="btn btn-outline-primary btn-sm">
                                        Đọc tiếp →
                                    </a>
                                </div>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>
                                    Đã thích lúc: <?php echo date('d/m/Y H:i', strtotime($post['created_at'])); ?>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Sidebar -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-heart-fill text-danger me-2"></i>
                        Thống kê thích
                    </h5>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Tổng bài viết đã thích:</span>
                        <span class="badge bg-primary"><?php echo count($likedPosts); ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Bài viết gần nhất:</span>
                        <small>
                            <?php echo !empty($likedPosts) ? date('d/m/Y', strtotime($likedPosts[0]['created_at'])) : 'N/A'; ?>
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
