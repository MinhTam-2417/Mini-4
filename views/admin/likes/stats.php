<?php
// Admin likes stats view
// Layout được xử lý bởi Controller base class
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thống kê lượt like</h1>
        <a href="/Mini-4/public/admin/likes" class="btn btn-primary btn-sm">
            <i class="fas fa-list"></i> Danh sách
        </a>
    </div>

    <!-- Thống kê tổng quan -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tổng lượt like
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo number_format($stats['total_likes']); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-heart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Người dùng đã like
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo number_format($stats['total_users']); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Bài viết được like
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo number_format($stats['total_posts']); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Trung bình like/bài viết
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo $stats['total_posts'] > 0 ? number_format($stats['total_likes'] / $stats['total_posts'], 1) : 0; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Top bài viết nhiều like -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top 5 bài viết nhiều like nhất</h6>
                </div>
                <div class="card-body">
                    <?php if (empty($stats['top_posts'])): ?>
                        <p class="text-muted">Chưa có dữ liệu.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Bài viết</th>
                                        <th>Số lượt like</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($stats['top_posts'] as $post): ?>
                                        <tr>
                                            <td>
                                                <a href="/Mini-4/public/admin/likes?action=by_post&id=<?php echo $post['id'] ?? ''; ?>">
                                                    <?php echo htmlspecialchars($post['title']); ?>
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary"><?php echo $post['like_count']; ?></span>
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

        <!-- Top user like nhiều -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top 5 người dùng like nhiều nhất</h6>
                </div>
                <div class="card-body">
                    <?php if (empty($stats['top_users'])): ?>
                        <p class="text-muted">Chưa có dữ liệu.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Người dùng</th>
                                        <th>Số lượt like</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($stats['top_users'] as $user): ?>
                                        <tr>
                                            <td>
                                                <a href="/Mini-4/public/admin/likes?action=by_user&id=<?php echo $user['id'] ?? ''; ?>">
                                                    <?php echo htmlspecialchars($user['full_name'] ?: $user['username']); ?>
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge bg-success"><?php echo $user['like_count']; ?></span>
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
    </div>
</div>
