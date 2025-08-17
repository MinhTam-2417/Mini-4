<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý Thẻ (Tags)</h1>
        <a href="/Mini-4/public/admin/tags/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Thêm Thẻ Mới
        </a>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['success']; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error']; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Tìm kiếm -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tìm kiếm Thẻ</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="/Mini-4/public/admin/tags">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="search" 
                                   placeholder="Nhập tên thẻ để tìm kiếm..." 
                                   value="<?php echo htmlspecialchars($search ?? ''); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Tìm kiếm
                        </button>
                        <a href="/Mini-4/public/admin/tags" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Xóa bộ lọc
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Danh sách tags -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách Thẻ</h6>
        </div>
        <div class="card-body">
            <?php if (empty($tags)): ?>
                <div class="text-center py-4">
                    <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Chưa có thẻ nào</h5>
                    <p class="text-muted">Bắt đầu tạo thẻ đầu tiên để tổ chức bài viết của bạn.</p>
                    <a href="/Mini-4/public/admin/tags/create" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm Thẻ Mới
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="20%">Tên Thẻ</th>
                                <th width="15%">Slug</th>
                                <th width="25%">Mô tả</th>
                                <th width="10%">Màu sắc</th>
                                <th width="10%">Số bài viết</th>
                                <th width="15%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tags as $tag): ?>
                                <tr>
                                    <td><?php echo $tag['id']; ?></td>
                                    <td>
                                        <span class="badge" style="background-color: <?php echo htmlspecialchars($tag['color']); ?>; color: white;">
                                            <?php echo htmlspecialchars($tag['name']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <code><?php echo htmlspecialchars($tag['slug']); ?></code>
                                    </td>
                                    <td>
                                        <?php if (!empty($tag['description'])): ?>
                                            <?php echo htmlspecialchars(substr($tag['description'], 0, 100)); ?>
                                            <?php if (strlen($tag['description']) > 100): ?>...<?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-muted">Không có mô tả</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="color-preview" style="width: 20px; height: 20px; background-color: <?php echo htmlspecialchars($tag['color']); ?>; border-radius: 3px; margin-right: 8px;"></div>
                                            <code><?php echo htmlspecialchars($tag['color']); ?></code>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            <?php echo $tag['post_count'] ?? 0; ?> bài viết
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="/Mini-4/public/admin/tags/edit/<?php echo $tag['id']; ?>" 
                                               class="btn btn-sm btn-primary" 
                                               title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    onclick="confirmDelete(<?php echo $tag['id']; ?>, '<?php echo htmlspecialchars($tag['name']); ?>')"
                                                    title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function confirmDelete(tagId, tagName) {
    if (confirm('Bạn có chắc chắn muốn xóa thẻ "' + tagName + '" không?\n\nLưu ý: Thẻ đang được sử dụng trong bài viết sẽ không thể xóa.')) {
        window.location.href = '/Mini-4/public/admin/tags/delete/' + tagId;
    }
}

$(document).ready(function() {
    $('#dataTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Vietnamese.json"
        },
        "order": [[ 0, "desc" ]]
    });
});
</script>

<style>
.color-preview {
    border: 1px solid #ddd;
}
</style>
