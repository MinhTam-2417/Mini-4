<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-pencil-square me-2"></i>Chỉnh sửa bài viết
    </h2>
    <a href="/Mini-4/public/post/<?php echo $post['id']; ?>" class="btn btn-outline-secondary">
        <i class="bi bi-eye me-2"></i>Xem bài viết
    </a>
</div>

<!-- Edit Post Form -->
<form action="/Mini-4/public/post/<?php echo $post['id']; ?>/update" method="POST" enctype="multipart/form-data">
    <div class="row">
        <!-- Left Column - Post Content -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề bài viết *</label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?php echo htmlspecialchars($post['title']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="content" class="form-label">Nội dung bài viết *</label>
                        <textarea class="form-control" id="content" name="content" rows="12" required><?php echo htmlspecialchars($post['content']); ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Mô tả ngắn</label>
                        <textarea class="form-control" id="excerpt" name="excerpt" rows="3"><?php echo htmlspecialchars($post['excerpt'] ?? ''); ?></textarea>
                        <div class="form-text">Mô tả ngắn sẽ hiển thị trong danh sách bài viết</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column - Post Settings -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-gear me-2"></i>Cài đặt bài viết
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Danh mục</label>
                        <select class="form-select" id="category_id" name="category_id">
                            <option value="">Chọn danh mục</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>" 
                                        <?php echo $post['category_id'] == $category['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tags" class="form-label">Thẻ (Tags)</label>
                        <select class="form-select" id="tags" name="tags[]" multiple>
                            <?php 
                            $postTagIds = array_column($postTags ?? [], 'id');
                            foreach ($tags as $tag): 
                            ?>
                                <option value="<?php echo $tag['id']; ?>" 
                                        <?php echo in_array($tag['id'], $postTagIds) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($tag['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Giữ Ctrl (hoặc Cmd trên Mac) để chọn nhiều thẻ</div>
                        <div id="selected-tags" class="mt-2"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="featured_image" class="form-label">Hình ảnh đại diện</label>
                        <input type="file" class="form-control" id="featured_image" name="featured_image" 
                               accept="image/*">
                        <div class="form-text">Định dạng: JPG, PNG, GIF, WebP</div>
                        
                        <?php if (!empty($post['featured_image'])): ?>
                            <div class="mt-2">
                                <strong>Hình ảnh hiện tại:</strong><br>
                                <img src="/Mini-4/public/<?php echo htmlspecialchars($post['featured_image']); ?>" 
                                     alt="Current image" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                            </div>
                        <?php endif; ?>
                        
                        <div class="mt-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="image_fit" id="contain" value="contain" 
                                       <?php echo ($post['image_fit'] ?? 'contain') === 'contain' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="contain">Hiển thị toàn bộ hình ảnh</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="image_fit" id="cover" value="cover" 
                                       <?php echo ($post['image_fit'] ?? '') === 'cover' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="cover">Cắt hình ảnh để vừa khung</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" name="action" value="publish" class="btn btn-success">
                            <i class="bi bi-check-circle me-2"></i>Cập nhật và xuất bản
                        </button>
                        <button type="submit" name="action" value="draft" class="btn btn-secondary">
                            <i class="bi bi-save me-2"></i>Lưu bản nháp
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Post Information -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>Thông tin bài viết
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="text-muted small">Tạo</div>
                            <div class="fw-bold"><?php echo date('d/m/Y', strtotime($post['created_at'])); ?></div>
                        </div>
                        <div class="col-4">
                            <div class="text-muted small">Lượt xem</div>
                            <div class="fw-bold"><?php echo $post['view_count'] ?? 0; ?></div>
                        </div>
                        <div class="col-4">
                            <div class="text-muted small">Bình luận</div>
                            <div class="fw-bold"><?php echo $post['comment_count'] ?? 0; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
// Tags selection
document.getElementById('tags').addEventListener('change', function() {
    const selectedTags = Array.from(this.selectedOptions).map(option => option.text);
    const selectedTagsDiv = document.getElementById('selected-tags');
    
    if (selectedTags.length > 0) {
        selectedTagsDiv.innerHTML = selectedTags.map(tag => 
            `<span class="badge bg-primary me-1 mb-1">${tag}</span>`
        ).join('');
    } else {
        selectedTagsDiv.innerHTML = '';
    }
});

// Auto-generate excerpt from content
document.getElementById('content').addEventListener('input', function() {
    const excerptField = document.getElementById('excerpt');
    if (excerptField.value === '') {
        const content = this.value;
        const excerpt = content.substring(0, 200);
        if (content.length > 200) {
            excerptField.value = excerpt + '...';
        } else {
            excerptField.value = excerpt;
        }
    }
});

// Initialize selected tags display
document.addEventListener('DOMContentLoaded', function() {
    const tagsSelect = document.getElementById('tags');
    const selectedTags = Array.from(tagsSelect.selectedOptions).map(option => option.text);
    const selectedTagsDiv = document.getElementById('selected-tags');
    
    if (selectedTags.length > 0) {
        selectedTagsDiv.innerHTML = selectedTags.map(tag => 
            `<span class="badge bg-primary me-1 mb-1">${tag}</span>`
        ).join('');
    }
});
</script>
