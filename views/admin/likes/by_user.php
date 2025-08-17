<?php
// Admin likes by user view
// Layout được xử lý bởi Controller base class
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Bài viết đã like bởi: <?php echo htmlspecialchars($user['full_name'] ?: $user['username']); ?></h1>
        <div>
            <a href="/Mini-4/public/admin/likes" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <!-- Thông tin người dùng -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Thông tin người dùng</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                    <p><strong>Họ tên:</strong> <?php echo htmlspecialchars($user['full_name'] ?: 'N/A'); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>Vai trò:</strong> 
                        <span class="badge bg-<?php echo $user['role'] === 'admin' ? 'danger' : 'info'; ?>">
                            <?php echo $user['role'] === 'admin' ? 'Admin' : 'User'; ?>
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Danh sách bài viết đã like -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Danh sách bài viết đã like (<?php echo count($likes); ?> bài)
            </h6>
        </div>
        <div class="card-body">
            <?php if (empty($likes)): ?>
                <p class="text-muted">Người dùng này chưa like bài viết nào.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Bài viết</th>
                                <th>Ngày tạo bài viết</th>
                                <th>Thời gian like</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($likes as $index => $like): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td>
                                        <a href="/Mini-4/public/admin/likes?action=by_post&id=<?php echo $like['post_id']; ?>">
                                            <?php echo htmlspecialchars($like['title']); ?>
                                        </a>
                                    </td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($like['post_created_at'])); ?></td>
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
