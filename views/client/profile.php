<!-- Profile Header -->
<div class="card mb-4">
    <div class="card-body text-center">
        <div class="mb-3">
            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                 style="width: 100px; height: 100px;">
                <i class="bi bi-person text-white" style="font-size: 3rem;"></i>
            </div>
        </div>
        <h3><?php echo htmlspecialchars($user['full_name']); ?></h3>
        <p class="text-muted">@<?php echo htmlspecialchars($user['username']); ?></p>
        <?php if (!empty($user['bio'])): ?>
            <p class="text-muted"><?php echo htmlspecialchars($user['bio']); ?></p>
        <?php endif; ?>
    </div>
</div>

<!-- Profile Information -->
<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-person-circle me-2"></i>Thông tin cá nhân
                </h5>
            </div>
            <div class="card-body">
                <form action="/Mini-4/public/profile/update" method="POST">
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" 
                               value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="bio" class="form-label">Giới thiệu</label>
                        <textarea class="form-control" id="bio" name="bio" rows="3"><?php echo htmlspecialchars($user['bio'] ?? ''); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Cập nhật thông tin
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-shield-lock me-2"></i>Đổi mật khẩu
                </h5>
            </div>
            <div class="card-body">
                <form action="/Mini-4/public/profile/change-password" method="POST">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Mật khẩu mới</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_new_password" class="form-label">Xác nhận mật khẩu mới</label>
                        <input type="password" class="form-control" id="confirm_new_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-key me-2"></i>Đổi mật khẩu
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- User Posts -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="bi bi-file-text me-2"></i>Bài viết của tôi (<?php echo count($posts); ?>)
        </h5>
    </div>
    <div class="card-body">
        <?php if (empty($posts)): ?>
            <div class="text-center py-4">
                <i class="bi bi-file-text text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-2">Bạn chưa có bài viết nào</p>
                <a href="/Mini-4/public/post/create" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Tạo bài viết đầu tiên
                </a>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($posts as $post): ?>
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <?php if (!empty($post['featured_image'])): ?>
                                <img src="/Mini-4/public/<?php echo htmlspecialchars($post['featured_image']); ?>" 
                                     class="card-img-top" style="height: 150px; object-fit: cover;"
                                     alt="<?php echo htmlspecialchars($post['title']); ?>">
                            <?php endif; ?>
                            <div class="card-body">
                                <h6 class="card-title">
                                    <a href="/Mini-4/public/post/<?php echo $post['id']; ?>" 
                                       class="text-decoration-none text-dark">
                                        <?php echo htmlspecialchars($post['title']); ?>
                                    </a>
                                </h6>
                                <p class="card-text text-muted small">
                                    <?php echo htmlspecialchars($post['excerpt'] ?? substr(strip_tags($post['content']), 0, 80) . '...'); ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar me-1"></i>
                                        <?php echo date('d/m/Y', strtotime($post['created_at'])); ?>
                                    </small>
                                    <span class="badge bg-<?php echo $post['status'] === 'published' ? 'success' : 'secondary'; ?>">
                                        <?php echo $post['status'] === 'published' ? 'Đã xuất bản' : 'Bản nháp'; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <div class="d-flex gap-2">
                                    <a href="/Mini-4/public/post/<?php echo $post['id']; ?>/edit" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-pencil me-1"></i>Sửa
                                    </a>
                                    <a href="/Mini-4/public/post/<?php echo $post['id']; ?>" 
                                       class="btn btn-outline-info btn-sm">
                                        <i class="bi bi-eye me-1"></i>Xem
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- User Comments -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="bi bi-chat-dots me-2"></i>Bình luận của tôi (<?php echo count($comments); ?>)
        </h5>
    </div>
    <div class="card-body">
        <?php if (empty($comments)): ?>
            <div class="text-center py-4">
                <i class="bi bi-chat-dots text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-2">Bạn chưa có bình luận nào</p>
            </div>
        <?php else: ?>
            <?php foreach ($comments as $comment): ?>
                <div class="border-bottom pb-3 mb-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <p class="mb-1"><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                            <small class="text-muted">
                                <i class="bi bi-calendar me-1"></i>
                                <?php echo date('d/m/Y H:i', strtotime($comment['created_at'])); ?>
                            </small>
                        </div>
                        <a href="/Mini-4/public/post/<?php echo $comment['post_id']; ?>" 
                           class="btn btn-outline-primary btn-sm ms-2">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
