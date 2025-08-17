<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>Blog Mini4</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background-color: #f8f9fa; 
            font-family: 'Segoe UI', sans-serif;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            position: sticky;
            top: 0;
            overflow-y: auto;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            font-weight: 500;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 8px;
            margin: 2px 8px;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover {
            background-color: #495057;
            color: #fff;
            text-decoration: none;
        }
        .sidebar .nav-link.active {
            background-color: #007bff;
            color: #fff;
        }
        .sidebar .nav-link.active:hover {
            background-color: #0056b3;
        }
        .sidebar .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin: 1rem 0 2rem 0;
            padding: 10px;
        }
        
        .blogger-logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #ff5722, #ff7043);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
            box-shadow: 0 2px 8px rgba(255, 87, 34, 0.3);
        }
        
        .logo-text {
            font-size: 1.3rem;
            font-weight: bold;
            color: #fff;
        }
        .main-content {
            padding: 2rem;
            min-height: 100vh;
        }
        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e9ecef;
            border-radius: 12px 12px 0 0 !important;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .badge {
            font-size: 0.8rem;
        }
        .post-image {
            max-height: 400px;
            object-fit: contain;
            border-radius: 8px;
        }
        .related-post-image {
            height: 150px;
            object-fit: cover;
            border-radius: 8px 8px 0 0;
        }
        
        /* Dark mode styles */
        body.dark-mode {
            background-color: #1a1a1a !important;
            color: #e0e0e0;
        }
        
        body.dark-mode .main-content {
            background-color: #1a1a1a;
        }
        
        body.dark-mode .card {
            background-color: #2d2d2d;
            border-color: #404040;
            color: #e0e0e0;
        }
        
        body.dark-mode .card-header {
            background-color: #333333;
            border-bottom-color: #404040;
            color: #e0e0e0;
        }
        
        body.dark-mode .form-control {
            background-color: #333333;
            border-color: #404040;
            color: #e0e0e0;
        }
        
        body.dark-mode .form-control:focus {
            background-color: #333333;
            border-color: #007bff;
            color: #e0e0e0;
        }
        
        body.dark-mode .form-select {
            background-color: #333333;
            border-color: #404040;
            color: #e0e0e0;
        }
        
        body.dark-mode .btn-outline-secondary {
            color: #e0e0e0;
            border-color: #404040;
        }
        
        body.dark-mode .btn-outline-secondary:hover {
            background-color: #404040;
            color: #ffffff;
        }
        
        body.dark-mode .text-muted {
            color: #b0b0b0 !important;
        }
        
        body.dark-mode .bg-light {
            background-color: #333333 !important;
        }
        
        body.dark-mode .border-bottom {
            border-bottom-color: #404040 !important;
        }
        
        body.dark-mode .alert {
            background-color: #333333;
            border-color: #404040;
        }
        
        body.dark-mode .card-title {
            color: #ffffff !important;
        }
        
        body.dark-mode .card-title a {
            color: #ffffff !important;
        }
        
        body.dark-mode .card-title a:hover {
            color: #6ba5ff !important;
        }
        
        body.dark-mode .card-text {
            color: #e0e0e0 !important;
        }
        
        body.dark-mode .card-body {
            color: #e0e0e0 !important;
        }
        
        body.dark-mode .card-footer {
            background-color: #333333 !important;
            border-top-color: #404040 !important;
            color: #e0e0e0 !important;
        }
        
        body.dark-mode .btn {
            color: #ffffff;
        }
        
        body.dark-mode .btn-outline-danger {
            color: #ff6b6b;
            border-color: #ff6b6b;
        }
        
        body.dark-mode .btn-outline-danger:hover {
            background-color: #ff6b6b;
            color: #ffffff;
        }
        
        body.dark-mode .btn-outline-primary {
            color: #6ba5ff;
            border-color: #6ba5ff;
        }
        
        body.dark-mode .btn-outline-primary:hover {
            background-color: #6ba5ff;
            color: #ffffff;
        }
        
        body.dark-mode .btn-outline-warning {
            color: #ffd93d;
            border-color: #ffd93d;
        }
        
        body.dark-mode .btn-outline-warning:hover {
            background-color: #ffd93d;
            color: #000000;
        }
        
        body.dark-mode .btn-outline-secondary {
            color: #b0b0b0;
            border-color: #b0b0b0;
        }
        
        body.dark-mode .btn-outline-secondary:hover {
            background-color: #b0b0b0;
            color: #000000;
        }
        
        body.dark-mode .badge {
            color: #ffffff;
        }
        
        body.dark-mode .badge.bg-secondary {
            background-color: #6c757d !important;
        }
        
        body.dark-mode .dropdown-menu {
            background-color: #333333;
            border-color: #404040;
        }
        
        body.dark-mode .dropdown-item {
            color: #e0e0e0;
        }
        
        body.dark-mode .dropdown-item:hover {
            background-color: #404040;
            color: #ffffff;
        }
        
        body.dark-mode .modal-content {
            background-color: #2d2d2d;
            border-color: #404040;
        }
        
        body.dark-mode .modal-header {
            border-bottom-color: #404040;
        }
        
        body.dark-mode .modal-footer {
            border-top-color: #404040;
        }
        
        body.dark-mode .table {
            color: #e0e0e0;
        }
        
        body.dark-mode .table td,
        body.dark-mode .table th {
            border-color: #404040;
        }
        
        body.dark-mode .pagination .page-link {
            background-color: #333333;
            border-color: #404040;
            color: #e0e0e0;
        }
        
        body.dark-mode .pagination .page-link:hover {
            background-color: #404040;
            color: #ffffff;
        }
        
        body.dark-mode .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }
        
        body.dark-mode a {
            color: #6ba5ff;
        }
        
        body.dark-mode a:hover {
            color: #8bb8ff;
        }
        
        body.dark-mode a.text-dark {
            color: #ffffff !important;
        }
        
        body.dark-mode a.text-dark:hover {
            color: #6ba5ff !important;
        }
        
        /* Sidebar toggle styles */
        .sidebar {
            transition: transform 0.3s ease;
        }
        
        .sidebar.collapsed {
            transform: translateX(-100%);
        }
        
        .sidebar-toggle {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
            background: #343a40;
            border: none;
            color: white;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .sidebar-toggle:hover {
            background: #495057;
        }
        
        .sidebar-toggle.collapsed {
            left: 20px;
        }
        
        .main-content {
            transition: margin-left 0.3s ease;
        }
        
        .main-content.expanded {
            margin-left: 0;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                height: auto;
                position: relative;
            }
            .main-content {
                padding: 1rem;
            }
            .sidebar-toggle {
                display: block;
            }
        }
        
        @media (min-width: 769px) {
            .sidebar-toggle {
                display: block;
            }
        }
    </style>
</head>
<body data-logged-in="<?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>">
    <!-- Sidebar Toggle Button -->
    <button id="sidebar-toggle" class="sidebar-toggle" title="Ẩn/Hiện menu">
        <i class="bi bi-list"></i>
    </button>
    
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar d-flex flex-column" id="sidebar">
                <div class="logo">
                    <div class="blogger-logo">b</div>
                    <span class="logo-text">Blog Mini4</span>
                </div>
                
                <nav class="nav flex-column flex-grow-1">
                                         <a href="/Mini-4/public/" class="nav-link <?php echo $current_page === 'home' ? 'active' : ''; ?>">
                         <i class="bi bi-house-door"></i> Trang chủ
                     </a>
                     <a href="/Mini-4/public/search" class="nav-link <?php echo $current_page === 'search' ? 'active' : ''; ?>">
                         <i class="bi bi-search"></i> Tìm kiếm
                     </a>
                     <a href="/Mini-4/public/post/create" class="nav-link <?php echo $current_page === 'create' ? 'active' : ''; ?>">
                         <i class="bi bi-plus-square"></i> Tạo bài viết
                     </a>
                     <a href="/Mini-4/public/likes" class="nav-link <?php echo $current_page === 'likes' ? 'active' : ''; ?>">
                         <i class="bi bi-heart"></i> Bài viết đã thích
                     </a>
                     <a href="/Mini-4/public/saved-posts" class="nav-link <?php echo $current_page === 'saved_posts' ? 'active' : ''; ?>">
                         <i class="bi bi-bookmark-star"></i> Bài viết đã lưu
                     </a>
                     <a href="/Mini-4/public/hidden-posts" class="nav-link <?php echo $current_page === 'hidden_posts' ? 'active' : ''; ?>">
                         <i class="bi bi-eye-slash"></i> Bài viết đã ẩn
                     </a>
                     <a href="/Mini-4/public/user" class="nav-link <?php echo $current_page === 'profile' ? 'active' : ''; ?>">
                         <i class="bi bi-person"></i> Hồ sơ
                     </a>
                                         <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                         <a href="/Mini-4/public/admin" class="nav-link <?php echo $current_page === 'admin' ? 'active' : ''; ?>">
                             <i class="bi bi-gear"></i> Admin Panel
                         </a>
                     <?php endif; ?>
                </nav>
                
                <!-- Dark mode toggle -->
                <div class="p-3">
                    <button id="toggle-theme" class="btn btn-outline-light w-100 rounded-pill mb-3">
                        <i class="bi bi-moon-fill me-2"></i> Chế độ tối
                    </button>
                    
                    <!-- Logout button -->
                                         <?php if (isset($_SESSION['user_id'])): ?>
                         <a href="/Mini-4/public/logout" class="btn btn-danger w-100 rounded-pill">
                             <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                         </a>
                     <?php else: ?>
                         <a href="/Mini-4/public/login" class="btn btn-primary w-100 rounded-pill">
                             <i class="bi bi-box-arrow-in-right me-2"></i>Đăng nhập
                         </a>
                     <?php endif; ?>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 main-content" id="main-content">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['success']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['error']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <!-- Page Content -->
                <?php echo $content ?? ''; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/Mini-4/public/js/like.js"></script>
    <script src="/Mini-4/public/js/save-share.js"></script>
    <script src="/Mini-4/public/js/hide.js"></script>
    
    <!-- Sidebar Toggle Script -->
    <script>
        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            
            // Lấy trạng thái từ localStorage
            const isSidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            
            // Áp dụng trạng thái ban đầu
            if (isSidebarCollapsed) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
                sidebarToggle.classList.add('collapsed');
                sidebarToggle.innerHTML = '<i class="bi bi-arrow-right"></i>';
            }
            
            // Xử lý click toggle
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
                sidebarToggle.classList.toggle('collapsed');
                
                // Cập nhật icon
                if (sidebar.classList.contains('collapsed')) {
                    sidebarToggle.innerHTML = '<i class="bi bi-arrow-right"></i>';
                    localStorage.setItem('sidebarCollapsed', 'true');
                } else {
                    sidebarToggle.innerHTML = '<i class="bi bi-list"></i>';
                    localStorage.setItem('sidebarCollapsed', 'false');
                }
            });
            
            // Xử lý responsive
            function handleResize() {
                if (window.innerWidth <= 768) {
                    // Trên mobile, luôn hiển thị toggle button
                    sidebarToggle.style.display = 'block';
                } else {
                    // Trên desktop, vẫn hiển thị toggle button
                    sidebarToggle.style.display = 'block';
                }
            }
            
            // Lắng nghe sự kiện resize
            window.addEventListener('resize', handleResize);
            
            // Gọi lần đầu
            handleResize();
        });
    </script>
    
    <script>
        // Dark mode functionality
        function initDarkMode() {
            const toggleBtn = document.getElementById('toggle-theme');
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            
            // Apply saved preference
            if (isDarkMode) {
                document.body.classList.add('dark-mode');
                updateToggleButton(true);
            }
            
            // Toggle event
            toggleBtn.addEventListener('click', function() {
                const isDark = document.body.classList.toggle('dark-mode');
                localStorage.setItem('darkMode', isDark);
                updateToggleButton(isDark);
            });
        }
        
        function updateToggleButton(isDark) {
            const toggleBtn = document.getElementById('toggle-theme');
            if (isDark) {
                toggleBtn.innerHTML = '<i class="bi bi-sun-fill me-2"></i>Chế độ sáng';
            } else {
                toggleBtn.innerHTML = '<i class="bi bi-moon-fill me-2"></i>Chế độ tối';
            }
        }
        
        // Initialize dark mode when page loads
        document.addEventListener('DOMContentLoaded', initDarkMode);

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>
