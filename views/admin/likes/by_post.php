<?php
// Admin likes by post view
// Layout được xử lý bởi Controller base class
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Lượt like bài viết: <?php echo htmlspecialchars($post['title']); ?></h1>
        <div>
            <a href="/Mini-4/public/admin/likes" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <!-- Thông tin bài viết -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Thông tin bài viết</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Tiêu đề:</strong> <?php echo htmlspecialchars($post['title']); ?></p>
                    <p><strong>Tác giả:</strong> <?php echo htmlspecialchars($post['author_name'] ?? 'N/A'); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Ngày tạo:</strong> <?php echo date('d/m/Y H:i', strtotime($post['created_at'])); ?></p>
                    <p><strong>Trạng thái:</strong> 
                        <span class="badge bg-<?php echo $post['status'] === 'published' ? 'success' : 'warning'; ?>">
                            <?php echo $post['status'] === 'published' ? 'Đã xuất bản' : 'Bản nháp'; ?>
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Danh sách người đã like -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Danh sách người đã like (<?php echo count($likes); ?> lượt)
            </h6>
        </div>
        <div class="card-body">
            <?php if (empty($likes)): ?>
                <p class="text-muted">Chưa có ai like bài viết này.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Người dùng</th>
                                <th>Thời gian like</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($likes as $index => $like): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td>
                                        <a href="/Mini-4/public/admin/likes?action=by_user&id=<?php echo $like['user_id']; ?>">
                                            <?php echo htmlspecialchars($like['full_name'] ?: $like['username']); ?>
                                        </a>
                                    </td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($like['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
