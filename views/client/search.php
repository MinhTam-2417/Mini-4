<!-- Search Form -->
<div class="card mb-4">
    <div class="card-body">
        <h3 class="card-title mb-3">
            <i class="bi bi-search me-2"></i>Tìm kiếm bài viết
        </h3>
        
        <form method="GET" action="/Mini-4/public/search">
            <div class="row">
                <div class="col-md-8">
                    <input type="text" class="form-control" name="q" 
                           value="<?php echo htmlspecialchars($keyword); ?>" 
                           placeholder="Nhập từ khóa tìm kiếm...">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="category">
                        <option value="">Tất cả danh mục</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>" 
                                    <?php echo $selectedCategory == $category['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Search Results -->
<?php if (!empty($keyword)): ?>
    <div class="mb-3">
        <h4>Kết quả tìm kiếm cho "<?php echo htmlspecialchars($keyword); ?>"</h4>
        <p class="text-muted">Tìm thấy <?php echo count($posts); ?> bài viết</p>
    </div>
    
    <?php if (empty($posts)): ?>
        <div class="text-center py-5">
            <i class="bi bi-search text-muted" style="font-size: 4rem;"></i>
            <h4 class="text-muted mt-3">Không tìm thấy bài viết nào</h4>
            <p class="text-muted">Thử tìm kiếm với từ khóa khác hoặc danh mục khác</p>
        </div>
    <?php else: ?>
        <div class="row">
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
                                    <span class="text-muted small">
                                        <i class="bi bi-heart me-1"></i>
                                        <?php echo $post['like_count'] ?? 0; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php else: ?>
    <div class="text-center py-5">
        <i class="bi bi-search text-muted" style="font-size: 4rem;"></i>
        <h4 class="text-muted mt-3">Tìm kiếm bài viết</h4>
        <p class="text-muted">Nhập từ khóa và chọn danh mục để bắt đầu tìm kiếm</p>
    </div>
<?php endif; ?>
