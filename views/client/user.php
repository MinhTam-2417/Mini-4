<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Trang cá nhân</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #fafafa;
      font-family: 'Segoe UI', sans-serif;
    }

    .sidebar {
      height: 100vh;
      background-color: #fff;
      border-right: 1px solid #ddd;
      padding: 1rem 0.5rem;
      position: sticky;
      top: 0;
    }

    .sidebar .nav-link {
      color: #000;
      font-weight: 500;
      font-size: 1.1rem;
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 15px;
      border-radius: 10px;
      transition: background 0.2s;
    }

    .sidebar .nav-link:hover {
      background-color: #f0f0f0;
      text-decoration: none;
    }

    .sidebar .logo {
      font-size: 2rem;
      font-weight: bold;
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .tab-link {
      font-weight: 500;
      color: #000;
    }

    .tab-link.active {
      border-bottom: 2px solid #000;
      color: #000;
    }

    .rounded-pill-custom {
      border-radius: 30px;
    }

    @media (max-width: 768px) {
      .sidebar {
        display: none;
      }
    }
    .main-content {
      max-width: 700px;
      margin: 0 auto;
    }

  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 sidebar d-flex flex-column align-items-start">
      <div class="logo">🧵</div>

      <a href="/Mini-4/views/client/home.php" class="nav-link"><i class="bi bi-house-door"></i> Trang chủ</a>
      <a href="#" class="nav-link"><i class="bi bi-search"></i> Tìm kiếm</a>
      <a href="/Mini-4/views/client/post_detail.php" class="nav-link"><i class="bi bi-plus-square"></i> Bài viết</a>
      <a href="#" class="nav-link"><i class="bi bi-heart"></i> Thích</a>
      <a href="/Mini-4/views/client/user.php" class="nav-link"><i class="bi bi-person"></i> Hồ sơ</a>
      <a href="#" class="nav-link"><i class="bi bi-three-dots"></i> Khác</a>

      <div class="mt-auto w-100 px-3">
        <?php if (isset($_SESSION['user_id'])): ?>
          <form action="/blog-mini/public/logout" method="POST">
            <button type="submit" class="btn btn-dark w-100 rounded-pill mt-4">Đăng xuất</button>
          </form>
        <?php else: ?>
          <a href="/Mini-4/views/client/login.php" class="btn btn-dark w-100 rounded-pill mt-4">Đăng nhập</a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Nội dung trang cá nhân -->
    <div class="col-md-10 py-4">
      <div class="main-content">
              <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          <img src="<?= $user['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($user['name']) ?>" class="rounded-circle me-3" width="96" height="96" alt="avatar">
          <div>
            <h5 class="mb-0 fw-bold"><?= htmlspecialchars($user['name']) ?></h5>
            <div class="text-muted">@<?= htmlspecialchars($user['username']) ?></div>
            <small class="text-muted">✨🌸 Vui vẻ nè! <a href="#">@friend</a></small><br>
            <small class="text-muted">Được theo dõi bởi 18 người</small>
          </div>
        </div>
        <button class="btn btn-outline-secondary rounded-pill-custom"><i class="bi bi-pencil-square"></i></button>
      </div>

      <ul class="nav mt-4 border-bottom">
        <li class="nav-item me-4"><a class="nav-link tab-link active" href="#">Home</a></li>
        <li class="nav-item me-4"><a class="nav-link tab-link" href="#">Trả lời</a></li>
        <li class="nav-item me-4"><a class="nav-link tab-link" href="#">Media</a></li>
        <li class="nav-item"><a class="nav-link tab-link" href="#">Repost</a></li>
      </ul>

      <div class="d-flex align-items-start mt-4">
        <img src="<?= $user['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($user['name']) ?>" class="rounded-circle me-2" width="48" height="48">
        <div class="flex-grow-1">
          <textarea class="form-control border-0 border-bottom rounded-0" rows="2" placeholder="Bạn đang nghĩ gì?"></textarea>
          <div class="text-end mt-2">
            <button class="btn btn-dark btn-sm rounded-pill-custom px-4">Đăng</button>
          </div>
        </div>
      </div>

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
    </div> <!-- Kết thúc nội dung -->
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
