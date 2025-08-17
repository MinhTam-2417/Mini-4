<?php include __DIR__ . '/layout/main.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-share"></i> Lịch sử chia sẻ
                    </h4>
                </div>
                <div class="card-body">
                    <?php if (empty($share_history)): ?>
                        <div class="text-center py-5">
                            <i class="bi bi-share-x display-1 text-muted"></i>
                            <h5 class="mt-3">Chưa có lịch sử chia sẻ</h5>
                            <p class="text-muted">Hãy chia sẻ những bài viết bạn thích!</p>
                            <a href="/Mini-4/public/" class="btn btn-primary">
                                <i class="bi bi-house"></i> Về trang chủ
                            </a>
                        </div>
                    <?php else: ?>
                        <?php foreach ($share_history as $share): ?>
                            <div class="card mb-3">
                                <div class="row g-0">
                                    <?php if (!empty($share['featured_image'])): ?>
                                        <div class="col-md-4">
                                            <img src="/Mini-4/public/<?php echo htmlspecialchars($share['featured_image']); ?>" 
                                                 class="img-fluid rounded-start h-100" 
                                                 style="object-fit: cover; height: 150px;"
                                                 alt="<?php echo htmlspecialchars($share['title']); ?>">
                                        </div>
                                    <?php endif; ?>
                                    <div class="col-md-<?php echo !empty($share['featured_image']) ? '8' : '12'; ?>">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <h6 class="card-title">
                                                        <a href="/Mini-4/public/post/<?php echo $share['id']; ?>" 
                                                           class="text-decoration-none">
                                                            <?php echo htmlspecialchars($share['title']); ?>
                                                        </a>
                                                    </h6>
                                                    
                                                    <div class="small text-muted mb-2">
                                                        <i class="bi bi-person"></i> <?php echo htmlspecialchars($share['author_name']); ?>
                                                        <?php if (!empty($share['category_name'])): ?>
                                                            <span class="ms-2">
                                                                <i class="bi bi-tag"></i> <?php echo htmlspecialchars($share['category_name']); ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                
                                                <div class="text-end">
                                                    <?php
                                                    $shareTypeIcons = [
                                                        'facebook' => 'bi-facebook text-primary',
                                                        'twitter' => 'bi-twitter text-info',
                                                        'linkedin' => 'bi-linkedin text-primary',
                                                        'email' => 'bi-envelope text-success',
                                                        'copy_link' => 'bi-link-45deg text-secondary'
                                                    ];
                                                    
                                                    $shareTypeNames = [
                                                        'facebook' => 'Facebook',
                                                        'twitter' => 'Twitter',
                                                        'linkedin' => 'LinkedIn',
                                                        'email' => 'Email',
                                                        'copy_link' => 'Copy Link'
                                                    ];
                                                    
                                                    $iconClass = $shareTypeIcons[$share['share_type']] ?? 'bi-share';
                                                    $typeName = $shareTypeNames[$share['share_type']] ?? 'Chia sẻ';
                                                    ?>
                                                    <span class="badge bg-light text-dark">
                                                        <i class="bi <?php echo $iconClass; ?>"></i>
                                                        <?php echo $typeName; ?>
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar"></i> Chia sẻ: <?php echo date('d/m/Y H:i', strtotime($share['shared_at'])); ?>
                                                </small>
                                                
                                                <a href="/Mini-4/public/post/<?php echo $share['id']; ?>" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i> Xem bài viết
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <!-- Pagination -->
                        <?php if (isset($total_pages) && $total_pages > 1): ?>
                            <nav aria-label="Share history pagination">
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


