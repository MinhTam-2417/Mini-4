<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Blog Mini4</h1>
    <a href="/Mini-4/public/post/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Tạo bài viết
    </a>
</div>

<!-- Posts Grid -->
<div class="row">
    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <?php if (!empty($post['featured_image'])): ?>
                        <img src="/Mini-4/public/<?php echo htmlspecialchars($post['featured_image']); ?>" 
                             class="card-img-top" style="height: 200px; object-fit: cover;"
                             alt="<?php echo htmlspecialchars($post['title']); ?>">
                    <?php else: ?>
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                             style="height: 200px;">
                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="/Mini-4/public/post/<?php echo $post['id']; ?>" 
                               class="text-decoration-none text-dark">
                                <?php echo htmlspecialchars($post['title']); ?>
                            </a>
                        </h5>
                        
                        <p class="card-text text-muted">
                            <?php echo htmlspecialchars($post['excerpt'] ?? substr(strip_tags($post['content']), 0, 100) . '...'); ?>
                        </p>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="bi bi-person me-1"></i>
                                <?php echo htmlspecialchars($post['author_name']); ?>
                            </small>
                            <small class="text-muted">
                                <i class="bi bi-calendar me-1"></i>
                                <?php echo date('d/m/Y', strtotime($post['created_at'])); ?>
                            </small>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-transparent">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <?php if (!empty($post['category_name'])): ?>
                                    <span class="badge bg-secondary me-1">
                                        <?php echo htmlspecialchars($post['category_name']); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex gap-2">
                                <span class="text-muted small">
                                    <i class="bi bi-eye me-1"></i>
                                    <?php echo $post['view_count'] ?? 0; ?>
                                </span>
                                <span class="like-count text-muted small" data-post-id="<?php echo $post['id']; ?>" title="Hover để xem ai đã like">
                                    <i class="bi bi-heart me-1"></i>
                                    <?php echo $post['like_count'] ?? 0; ?>
                                </span>
                                <span class="text-muted small" data-save-count="<?php echo $post['id']; ?>">
                                    <i class="bi bi-bookmark me-1"></i>
                                    <?php echo $post['save_count'] ?? 0; ?>
                                </span>
                                <span class="text-muted small">
                                    <i class="bi bi-share me-1"></i>
                                    <?php echo $post['share_count'] ?? 0; ?>
                                </span>
                                <button class="like-btn btn btn-sm <?php echo isset($post['user_liked']) && $post['user_liked'] ? 'btn-danger liked' : 'btn-outline-danger'; ?>" 
                                        data-post-id="<?php echo $post['id']; ?>" 
                                        title="<?php echo isset($post['user_liked']) && $post['user_liked'] ? 'Bỏ thích' : 'Thích'; ?>">
                                    <span class="like-icon">
                                        <i class="bi bi-heart<?php echo isset($post['user_liked']) && $post['user_liked'] ? '-fill' : ''; ?>"></i>
                                    </span>
                                </button>
                                <button class="save-btn btn btn-sm <?php echo isset($post['user_saved']) && $post['user_saved'] ? 'btn-primary' : 'btn-outline-primary'; ?>" 
                                        data-post-id="<?php echo $post['id']; ?>" 
                                        title="<?php echo isset($post['user_saved']) && $post['user_saved'] ? 'Bỏ lưu' : 'Lưu'; ?>">
                                    <i class="bi bi-bookmark<?php echo isset($post['user_saved']) && $post['user_saved'] ? '-fill' : ''; ?>"></i>
                                </button>
                                <button class="share-btn btn btn-sm btn-outline-secondary" 
                                        data-post-id="<?php echo $post['id']; ?>" 
                                        data-post-title="<?php echo htmlspecialchars($post['title']); ?>"
                                        title="Chia sẻ">
                                    <i class="bi bi-share"></i>
                                </button>
                                <button class="hide-btn btn btn-sm btn-outline-warning" 
                                        data-post-id="<?php echo $post['id']; ?>" 
                                        title="Ẩn bài viết">
                                    <span class="hide-icon">
                                        <i class="bi bi-eye"></i>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="text-center py-5">
                <i class="bi bi-journal-text text-muted" style="font-size: 4rem;"></i>
                <h3 class="mt-3 text-muted">Chưa có bài viết nào</h3>
                <p class="text-muted">Hãy là người đầu tiên tạo bài viết!</p>
                <a href="/Mini-4/public/post/create" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Tạo bài viết đầu tiên
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>
