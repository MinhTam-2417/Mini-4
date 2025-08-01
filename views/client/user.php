<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Trang cá nhân</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .avatar-lg {
      width: 96px;
      height: 96px;
      object-fit: cover;
    }
    .rounded-pill-custom {
      border-radius: 30px;
    }
    .tab-link {
      font-weight: 500;
      color: #000;
    }
    .tab-link.active {
      border-bottom: 2px solid #000;
      color: #000;
    }
  </style>
</head>
<body>
  <div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center">
        <img src="<?= $user['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($user['name']) ?>" class="rounded-circle avatar-lg me-3" alt="avatar">
        <div>
          <h5 class="mb-0 fw-bold"><?= htmlspecialchars($user['name']) ?></h5>
          <div class="text-muted">@<?= htmlspecialchars($user['username']) ?></div>
          <small class="text-muted">✨🌸 Vui vẻ nè! <a href="#">@friend</a></small><br>
          <small class="text-muted">Được theo dõi bởi 18 người</small>
        </div>
      </div>
      <button class="btn btn-outline-secondary rounded-pill-custom">Chỉnh sửa trang cá nhân</button>
    </div>

    <!-- Tabs -->
    <ul class="nav mt-4 border-bottom">
      <li class="nav-item me-4">
        <a class="nav-link tab-link active" href="#">Home</a>
      </li>
      <li class="nav-item me-4">
        <a class="nav-link tab-link" href="#">Trả lời</a>
      </li>
      <li class="nav-item me-4">
        <a class="nav-link tab-link" href="#">Media</a>
      </li>
      <li class="nav-item">
        <a class="nav-link tab-link" href="#">Repost</a>
      </li>
    </ul>

    <!-- Post Form -->
    <div class="d-flex align-items-start mt-4">
      <img src="<?= $user['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($user['name']) ?>" class="rounded-circle me-2" width="48" height="48">
      <div class="flex-grow-1">
        <textarea class="form-control border-0 border-bottom rounded-0" rows="2" placeholder="Bạn đang nghĩ gì?"></textarea>
        <div class="text-end mt-2">
          <button class="btn btn-dark btn-sm rounded-pill-custom px-4">Đăng</button>
        </div>
      </div>
    </div>

    <!-- Complete profile suggestions -->
    <div class="mt-5 p-4 rounded-4 border bg-light">
      <h6 class="fw-bold mb-4">Hoàn tất hồ sơ</h6>
      <div class="row text-center">
        <div class="col-md-4 mb-3">
          <div class="bg-white p-3 rounded-3 shadow-sm h-100">
            <i class="bi bi-person-plus fs-3 mb-2 text-dark"></i>
            <p class="fw-semibold mb-1">Theo dõi 10 người đầu tiên</p>
            <button class="btn btn-dark btn-sm rounded-pill-custom">Xem</button>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="bg-white p-3 rounded-3 shadow-sm h-100">
            <i class="bi bi-chat-dots fs-3 mb-2 text-dark"></i>
            <p class="fw-semibold mb-1">Tạo bài viết đầu tiên</p>
            <button class="btn btn-outline-secondary btn-sm rounded-pill-custom">Xong</button>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="bg-white p-3 rounded-3 shadow-sm h-100">
            <i class="bi bi-image fs-3 mb-2 text-dark"></i>
            <p class="fw-semibold mb-1">Thêm ảnh đại diện</p>
            <button class="btn btn-outline-secondary btn-sm rounded-pill-custom">Xong</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
