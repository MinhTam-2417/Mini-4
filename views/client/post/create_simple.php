<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-plus-circle me-2"></i>Tạo bài viết mới
    </h2>
    <a href="/Mini-4/public/" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Quay lại
    </a>
</div>

<!-- Create Post Form -->
<form action="/Mini-4/public/post/store" method="POST" enctype="multipart/form-data">
    <div class="row">
        <!-- Left Column - Post Content -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề bài viết</label>
                        <input type="text" class="form-control" id="title" name="title" 
                               placeholder="Nhập tiêu đề bài viết..." required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="content" class="form-label">Nội dung bài viết</label>
                        <textarea class="form-control" id="content" name="content" rows="12" 
                                  placeholder="Viết nội dung bài viết của bạn..." required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="featured_image" class="form-label">Hình ảnh đại diện</label>
                        <input type="file" class="form-control" id="featured_image" name="featured_image" 
                               accept="image/*">
                        <div class="form-text">Định dạng: JPG, PNG, GIF, WebP</div>
                        
                        <div class="mt-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="image_fit" id="contain" value="contain" checked>
                                <label class="form-check-label" for="contain">Hiển thị toàn bộ hình ảnh</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="image_fit" id="cover" value="cover">
                                <label class="form-check-label" for="cover">Cắt hình ảnh để vừa khung</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Mô tả ngắn</label>
                        <textarea class="form-control" id="excerpt" name="excerpt" rows="3" 
                                  placeholder="Mô tả ngắn gọn về bài viết (tự động tạo nếu để trống)"></textarea>
                        <div class="form-text">Để trống để tự động tạo mô tả từ nội dung</div>
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
                                <option value="<?php echo $category['id']; ?>">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tags" class="form-label">Thẻ (Tags)</label>
                        <select class="form-select" id="tags" name="tags[]" multiple>
                            <?php foreach ($tags as $tag): ?>
                                <option value="<?php echo $tag['id']; ?>">
                                    <?php echo htmlspecialchars($tag['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Giữ Ctrl (hoặc Cmd trên Mac) để chọn nhiều thẻ</div>
                        <div id="selected-tags" class="mt-2"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select class="form-select" id="status" name="action">
                            <option value="draft">Bản nháp</option>
                            <option value="publish">Xuất bản</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="preview" class="form-label">Xem trước</label>
                        <input type="text" class="form-control" id="preview" readonly>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" name="action" value="publish" class="btn btn-success">
                            <i class="bi bi-check-circle me-2"></i>Xuất bản
                        </button>
                        <button type="submit" name="action" value="draft" class="btn btn-secondary">
                            <i class="bi bi-save me-2"></i>Lưu bản nháp
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Writing Tips -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-lightbulb me-2"></i>Hướng dẫn
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Viết tiêu đề hấp dẫn
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Nội dung rõ ràng, có cấu trúc
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Chọn danh mục phù hợp
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Kiểm tra trước khi xuất bản
                        </li>
                    </ul>
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
</script>


