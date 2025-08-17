
                <!-- Alerts -->
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Post Header -->
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h1>
                        
                        <div class="text-muted mb-3">
                            <i class="bi bi-person"></i>
                            <span><?php echo htmlspecialchars($post['author_name']); ?></span>
                            <span class="mx-2">•</span>
                            <i class="bi bi-calendar"></i>
                            <span><?php echo date('d/m/Y', strtotime($post['created_at'])); ?></span>
                            <span class="mx-2">•</span>
                            <i class="bi bi-eye"></i>
                            <span><?php echo $post['view_count'] ?? 0; ?> lượt xem</span>
                            <span class="mx-2">•</span>
                            <span class="like-count" data-post-id="<?php echo $post['id']; ?>" title="Hover để xem ai đã like">
                                <i class="bi bi-heart"></i>
                                <span><?php echo $post['like_count'] ?? 0; ?> lượt thích</span>
                            </span>
                            <span class="mx-2">•</span>
                            <button class="like-btn btn btn-sm <?php echo isset($post['user_liked']) && $post['user_liked'] ? 'btn-danger liked' : 'btn-outline-danger'; ?>" 
                                    data-post-id="<?php echo $post['id']; ?>" 
                                    title="<?php echo isset($post['user_liked']) && $post['user_liked'] ? 'Bỏ thích' : 'Thích'; ?>">
                                <span class="like-icon">
                                    <i class="bi bi-heart<?php echo isset($post['user_liked']) && $post['user_liked'] ? '-fill' : ''; ?>"></i>
                                </span>
                            </button>
                        </div>
                        
                        <?php if (!empty($post['category_name'])): ?>
                            <div class="mb-3">
                                <span class="badge bg-secondary">
                                    <?php echo htmlspecialchars($post['category_name']); ?>
                                </span>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Tags -->
                        <?php if (!empty($post['tags'])): ?>
                            <div class="mb-3">
                                <strong>Tags:</strong>
                                <?php foreach ($post['tags'] as $tag): ?>
                                    <span class="badge me-1" style="background-color: <?php echo htmlspecialchars($tag['color']); ?>; color: white;">
                                        <?php echo htmlspecialchars($tag['name']); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Featured Image -->
                <?php if (!empty($post['featured_image'])): ?>
                    <div class="card">
                        <div class="card-body text-center">
                            <img src="/Mini-4/public/<?php echo htmlspecialchars($post['featured_image']); ?>" 
                                 alt="<?php echo htmlspecialchars($post['title']); ?>" 
                                 class="post-image img-fluid">
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Post Content -->
                <div class="card">
                    <div class="card-body">
                        <?php if (!empty($post['excerpt'])): ?>
                            <p class="lead"><?php echo htmlspecialchars($post['excerpt']); ?></p>
                        <?php endif; ?>
                        
                        <div class="post-content">
                            <?php echo nl2br(htmlspecialchars($post['content'])); ?>
                        </div>
                    </div>
                </div>

                <!-- Comments -->
                <div class="card">
                    <div class="card-body">
                        <h5>Bình luận (<?php echo count($comments); ?>)</h5>
                        
                        <!-- Form thêm bình luận -->
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <form method="POST" action="/Mini-4/public/comment/add" class="mb-4">
                                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                <div class="mb-3">
                                    <textarea name="content" class="form-control" rows="3" placeholder="Viết bình luận của bạn..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i> Gửi bình luận
                                </button>
                            </form>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> 
                                <a href="/Mini-4/public/login" class="alert-link">Đăng nhập</a> để bình luận
                            </div>
                        <?php endif; ?>
                        
                        <hr>
                        
                        <!-- Danh sách bình luận -->
                        <?php if (!empty($comments)): ?>
                            <?php foreach ($comments as $comment): ?>
                                <div class="border-bottom pb-3 mb-3">
                                    <strong><?php echo htmlspecialchars($comment['username']); ?></strong>
                                    <small class="text-muted ms-2"><?php echo date('d/m/Y H:i', strtotime($comment['created_at'])); ?></small>
                                    <p class="mb-0 mt-2"><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Related Posts -->
                <?php if (!empty($relatedPosts)): ?>
                    <div class="card">
                        <div class="card-body">
                            <h5>Bài viết liên quan</h5>
                            <div class="row">
                                <?php foreach ($relatedPosts as $relatedPost): ?>
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100">
                                            <?php if (!empty($relatedPost['featured_image'])): ?>
                                                <img src="/Mini-4/public/<?php echo htmlspecialchars($relatedPost['featured_image']); ?>" 
                                                     class="card-img-top" style="height: 150px; object-fit: cover;">
                                            <?php endif; ?>
                                            <div class="card-body">
                                                <h6 class="card-title">
                                                    <a href="/Mini-4/public/post/<?php echo $relatedPost['id']; ?>" class="text-decoration-none">
                                                        <?php echo htmlspecialchars($relatedPost['title']); ?>
                                                    </a>
                                                </h6>
                                                <small class="text-muted"><?php echo htmlspecialchars($relatedPost['author_name']); ?></small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

