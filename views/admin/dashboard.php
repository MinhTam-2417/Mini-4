<!-- Dashboard Content -->
<div class="main-content">
    <div class="page-header">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h2 class="mb-1"><i class="bi bi-speedometer2"></i> Dashboard</h2>
          <p class="welcome-text mb-0">Xin chào, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?>! Chào mừng bạn đến với Admin Panel.</p>
        </div>
        <div class="text-end">
          <small class="text-muted"><?php echo date('d/m/Y H:i'); ?></small>
        </div>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
      <div class="col-md-2">
        <div class="stats-card text-center">
          <div class="stats-icon text-primary">
            <i class="bi bi-file-text"></i>
          </div>
          <h3 class="mb-1"><?php echo $totalPosts; ?></h3>
          <p class="text-muted mb-0">Bài viết</p>
        </div>
      </div>
      <div class="col-md-2">
        <div class="stats-card text-center">
          <div class="stats-icon text-success">
            <i class="bi bi-people"></i>
          </div>
          <h3 class="mb-1"><?php echo $totalUsers; ?></h3>
          <p class="text-muted mb-0">Người dùng</p>
        </div>
      </div>
      <div class="col-md-2">
        <div class="stats-card text-center">
          <div class="stats-icon text-warning">
            <i class="bi bi-chat-dots"></i>
          </div>
          <h3 class="mb-1"><?php echo $totalComments; ?></h3>
          <p class="text-muted mb-0">Bình luận</p>
        </div>
      </div>
      <div class="col-md-2">
        <div class="stats-card text-center">
          <div class="stats-icon text-info">
            <i class="bi bi-tags"></i>
          </div>
          <h3 class="mb-1"><?php echo $totalCategories; ?></h3>
          <p class="text-muted mb-0">Danh mục</p>
        </div>
      </div>
      <div class="col-md-2">
        <div class="stats-card text-center">
          <div class="stats-icon text-danger">
            <i class="bi bi-tag"></i>
          </div>
          <h3 class="mb-1"><?php echo $totalTags ?? 0; ?></h3>
          <p class="text-muted mb-0">Thẻ</p>
        </div>
      </div>
    </div>

    <!-- Recent Content -->
    <div class="row">
      <div class="col-md-6">
        <div class="stats-card">
          <h5><i class="bi bi-file-text"></i> Bài viết gần đây</h5>
          <?php if (!empty($recentPosts)): ?>
            <?php foreach ($recentPosts as $post): ?>
              <div class="recent-item">
                <div class="d-flex justify-content-between">
                  <strong><?php echo htmlspecialchars($post['title'] ?? ''); ?></strong>
                  <small class="text-muted"><?php echo date('d/m/Y', strtotime($post['created_at'] ?? 'now')); ?></small>
                </div>
                <div class="text-muted small">
                  <i class="bi bi-person"></i> <?php echo htmlspecialchars($post['author_name'] ?? ''); ?>
                  <?php if (!empty($post['category_name'])): ?>
                    <span class="mx-2">•</span>
                    <i class="bi bi-tag"></i> <?php echo htmlspecialchars($post['category_name']); ?>
                  <?php endif; ?>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p class="text-muted">Chưa có bài viết nào.</p>
          <?php endif; ?>
        </div>
      </div>

      <div class="col-md-6">
        <div class="stats-card">
          <h5><i class="bi bi-chat-dots"></i> Bình luận gần đây</h5>
          <?php if (!empty($recentComments)): ?>
            <?php foreach ($recentComments as $comment): ?>
              <div class="recent-item">
                <div class="d-flex justify-content-between">
                  <strong><?php echo htmlspecialchars($comment['username'] ?? ''); ?></strong>
                  <small class="text-muted"><?php echo date('d/m/Y', strtotime($comment['created_at'] ?? 'now')); ?></small>
                </div>
                <div class="text-muted small">
                  <?php 
                  $content = $comment['content'] ?? '';
                  echo htmlspecialchars(substr($content, 0, 50)) . (strlen($content) > 50 ? '...' : ''); 
                  ?>
                </div>
                <div class="text-muted small">
                  <i class="bi bi-file-text"></i> <?php echo htmlspecialchars($comment['post_title'] ?? 'Không có tiêu đề'); ?>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p class="text-muted">Chưa có bình luận nào.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
