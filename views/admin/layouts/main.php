<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Blog Mini4</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }
        
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
            padding-bottom: 20px;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .admin-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .blogger-logo {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #ff5722, #ff7043);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            font-weight: bold;
            color: white;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
            box-shadow: 0 2px 8px rgba(255, 87, 34, 0.3);
        }
        
        .sidebar-header h3 {
            color: white;
            margin: 0;
            font-size: 1.3rem;
            font-weight: bold;
        }
        
        .sidebar-nav {
            padding: 20px 0;
            min-height: calc(100vh - 200px);
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }
        
        /* Đảm bảo tất cả nav-item hiển thị */
        .nav-item {
            margin: 5px 15px;
            min-height: 45px;
            display: flex;
            align-items: center;
            opacity: 1 !important;
            visibility: visible !important;
        }
        
        .nav-item {
            margin: 5px 15px;
            min-height: 45px;
            display: flex;
            align-items: center;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        
        .nav-link:hover {
            color: white;
            background-color: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }
        
        .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.2);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }
        
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 15px 20px;
        }
        
        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            transform: translateY(-2px);
        }
        
        /* Stats Cards */
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
        }
        
        .stats-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .sidebar-toggle {
                display: block;
            }
        }
        
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }
        
        /* Dashboard specific styles */
        .page-header {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .welcome-text {
            color: #666;
            font-size: 1.1rem;
        }
        
        .recent-item {
            border-bottom: 1px solid #eee;
            padding: 0.75rem 0;
        }

        .recent-item:last-child {
            border-bottom: none;
        }
        
        /* Admin pages specific styles */
        .content-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .btn-action {
            margin: 0 2px;
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(0,0,0,0.02);
        }
    </style>
</head>
<body>
    <!-- Sidebar Toggle for Mobile -->
    <button class="sidebar-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="admin-logo">
                <div class="blogger-logo">b</div>
                <h3>Admin Panel</h3>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <div class="nav-item">
                <a href="/Mini-4/public/admin" class="nav-link <?php echo strpos($view, 'dashboard') !== false ? 'active' : ''; ?>">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </div>
            
            <div class="nav-item">
                <a href="/Mini-4/public/admin/posts" class="nav-link <?php echo strpos($view, 'posts') !== false ? 'active' : ''; ?>">
                    <i class="fas fa-file-alt"></i>
                    Bài viết
                </a>
            </div>
            
            <div class="nav-item">
                <a href="/Mini-4/public/admin/categories" class="nav-link <?php echo strpos($view, 'categories') !== false ? 'active' : ''; ?>">
                    <i class="fas fa-folder"></i>
                    Danh mục
                </a>
            </div>
            
            <div class="nav-item">
                <a href="/Mini-4/public/admin/tags" class="nav-link <?php echo strpos($view, 'tags') !== false ? 'active' : ''; ?>">
                    <i class="fas fa-tags"></i>
                    Thẻ
                </a>
            </div>
            
            <div class="nav-item">
                <a href="/Mini-4/public/admin/comments" class="nav-link <?php echo strpos($view, 'comments') !== false ? 'active' : ''; ?>">
                    <i class="fas fa-comments"></i>
                    Bình luận
                </a>
            </div>
            
            <div class="nav-item">
                <a href="/Mini-4/public/admin/likes" class="nav-link <?php echo strpos($view, 'likes') !== false ? 'active' : ''; ?>">
                    <i class="fas fa-heart"></i>
                    Lượt like
                </a>
            </div>
            
            <div class="nav-item">
                <a href="/Mini-4/public/admin/users" class="nav-link <?php echo strpos($view, 'users') !== false ? 'active' : ''; ?>">
                    <i class="fas fa-users"></i>
                    Người dùng
                </a>
            </div>
            
            <hr style="border-color: rgba(255,255,255,0.1); margin: 20px 15px;">
            
            <div class="nav-item">
                <a href="/Mini-4/public/" class="nav-link">
                    <i class="fas fa-home"></i>
                    Về trang chủ
                </a>
            </div>
            
            <div class="nav-item">
                <a href="/Mini-4/public/logout" class="nav-link" style="color: #ff6b6b;">
                    <i class="fas fa-sign-out-alt"></i>
                    Đăng xuất
                </a>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <?php 
        // Load view content - remove 'admin/' prefix from view path
        $viewName = str_replace('admin/', '', $view);
        $viewPath = __DIR__ . "/../{$viewName}.php";
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            echo "View file not found: $viewPath";
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }
        
        // Force refresh để đảm bảo hiển thị đầy đủ
        if (performance.navigation.type === 1) {
            // Page was refreshed
            console.log('Page refreshed - ensuring full sidebar display');
        }
        
        // Đảm bảo tất cả nav-item hiển thị
        document.addEventListener('DOMContentLoaded', function() {
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach(function(item) {
                item.style.display = 'flex';
                item.style.visibility = 'visible';
                item.style.opacity = '1';
            });
        });
        
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