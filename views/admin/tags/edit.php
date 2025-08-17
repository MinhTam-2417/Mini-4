<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Chỉnh sửa Thẻ</h1>
        <a href="/Mini-4/public/admin/tags" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Quay lại
        </a>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error']; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin Thẻ</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="/Mini-4/public/admin/tags/edit/<?php echo $tag['id']; ?>">
                        <div class="form-group">
                            <label for="name">Tên thẻ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?php echo htmlspecialchars($name ?? $tag['name']); ?>" 
                                   placeholder="Nhập tên thẻ..." required>
                            <small class="form-text text-muted">
                                Tên thẻ sẽ được hiển thị trên website và dùng để phân loại bài viết.
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="3" 
                                      placeholder="Mô tả ngắn gọn về thẻ này..."><?php echo htmlspecialchars($description ?? $tag['description']); ?></textarea>
                            <small class="form-text text-muted">
                                Mô tả giúp người dùng hiểu rõ hơn về nội dung của thẻ này.
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="color">Màu sắc</label>
                            <div class="input-group">
                                <input type="color" class="form-control" id="color" name="color" 
                                       value="<?php echo htmlspecialchars($color ?? $tag['color']); ?>" 
                                       style="width: 60px;">
                                <input type="text" class="form-control" id="colorText" 
                                       value="<?php echo htmlspecialchars($color ?? $tag['color']); ?>" 
                                       placeholder="#007bff" readonly>
                            </div>
                            <small class="form-text text-muted">
                                Màu sắc sẽ được sử dụng để hiển thị thẻ trên website.
                            </small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Cập nhật Thẻ
                            </button>
                            <a href="/Mini-4/public/admin/tags" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Xem trước</h6>
                </div>
                <div class="card-body">
                    <div class="preview-section">
                        <h6>Thẻ sẽ hiển thị như sau:</h6>
                        <div class="tag-preview mb-3">
                            <span class="badge" id="tagPreview" style="font-size: 14px; padding: 8px 12px;">
                                <span id="tagName"><?php echo htmlspecialchars($tag['name']); ?></span>
                            </span>
                        </div>
                        
                        <h6>Màu sắc hiện tại:</h6>
                        <div class="color-preview-box mb-3">
                            <div id="colorPreview" style="width: 100%; height: 40px; border-radius: 5px; border: 1px solid #ddd; background-color: <?php echo htmlspecialchars($tag['color']); ?>;"></div>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Thông tin thẻ:</strong>
                            <ul class="mb-0 mt-2">
                                <li><strong>ID:</strong> <?php echo $tag['id']; ?></li>
                                <li><strong>Slug:</strong> <code><?php echo htmlspecialchars($tag['slug']); ?></code></li>
                                <li><strong>Ngày tạo:</strong> <?php echo date('d/m/Y H:i', strtotime($tag['created_at'])); ?></li>
                                <li><strong>Cập nhật lần cuối:</strong> <?php echo date('d/m/Y H:i', strtotime($tag['updated_at'])); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Cập nhật preview khi thay đổi tên thẻ
    $('#name').on('input', function() {
        var name = $(this).val() || 'Tên thẻ';
        $('#tagName').text(name);
    });
    
    // Cập nhật preview khi thay đổi màu sắc
    $('#color').on('input', function() {
        var color = $(this).val();
        $('#colorText').val(color);
        $('#tagPreview').css('background-color', color);
        $('#colorPreview').css('background-color', color);
    });
    
    // Cập nhật color picker khi nhập text
    $('#colorText').on('input', function() {
        var color = $(this).val();
        if (/^#[0-9A-F]{6}$/i.test(color)) {
            $('#color').val(color);
            $('#tagPreview').css('background-color', color);
            $('#colorPreview').css('background-color', color);
        }
    });
    
    // Khởi tạo preview
    $('#name').trigger('input');
    $('#color').trigger('input');
});
</script>

<style>
.tag-preview {
    text-align: center;
}

.color-preview-box {
    text-align: center;
}

#colorText {
    font-family: monospace;
}
</style>
