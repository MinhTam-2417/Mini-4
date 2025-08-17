<!-- Likes Management Content -->
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý lượt like</h1>
        <div>
            <a href="/Mini-4/public/admin/likes/stats" class="btn btn-info btn-sm">
                <i class="fas fa-chart-bar"></i> Thống kê
            </a>
        </div>
    </div>

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

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách lượt like</h6>
        </div>
        <div class="card-body">
            <?php if (empty($likes)): ?>
                <p class="text-muted">Chưa có lượt like nào.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Người dùng</th>
                                <th>Bài viết</th>
                                <th>Thời gian</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($likes as $like): ?>
                                <tr>
                                    <td><?php echo $like['id']; ?></td>
                                    <td>
                                        <a href="/Mini-4/public/admin/likes?action=by_user&id=<?php echo $like['user_id']; ?>">
                                            <?php echo htmlspecialchars($like['full_name'] ?: $like['username']); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="/Mini-4/public/admin/likes?action=by_post&id=<?php echo $like['post_id']; ?>">
                                            <?php echo htmlspecialchars($like['post_title']); ?>
                                        </a>
                                    </td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($like['created_at'])); ?></td>
                                    <td>
                                        <form method="POST" action="/Mini-4/public/admin/likes/<?php echo $like['id']; ?>/delete" 
                                              style="display: inline;" 
                                              onsubmit="return confirm('Bạn có chắc muốn xóa lượt like này?')">
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
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
