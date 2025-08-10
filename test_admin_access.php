<?php
// Script test để kiểm tra truy cập admin
session_start();

echo "=== TEST TRUY CẬP ADMIN ===\n\n";

// 1. Test session
echo "1. Kiểm tra session...\n";
if (isset($_SESSION['user_id'])) {
    echo "✅ User ID: {$_SESSION['user_id']}\n";
} else {
    echo "❌ Chưa có user_id trong session\n";
}

if (isset($_SESSION['role'])) {
    echo "✅ Role: {$_SESSION['role']}\n";
} else {
    echo "❌ Chưa có role trong session\n";
}

if (isset($_SESSION['username'])) {
    echo "✅ Username: {$_SESSION['username']}\n";
} else {
    echo "❌ Chưa có username trong session\n";
}

echo "\n";

// 2. Test đăng nhập admin
echo "2. Test đăng nhập admin...\n";
try {
    require_once 'config/database.php';
    require_once 'core/Model.php';
    require_once 'models/User.php';
    
    $userModel = new User();
    $admin = $userModel->findByUsername('admin');
    
    if ($admin) {
        echo "✅ Tìm thấy tài khoản admin\n";
        echo "   ID: {$admin['id']}\n";
        echo "   Username: {$admin['username']}\n";
        echo "   Role: {$admin['role']}\n";
        
        // Test đăng nhập
        if (password_verify('admin123', $admin['password'])) {
            echo "✅ Mật khẩu admin123 đúng\n";
            
            // Set session
            $_SESSION['user_id'] = $admin['id'];
            $_SESSION['username'] = $admin['username'];
            $_SESSION['role'] = $admin['role'];
            
            echo "✅ Đã set session cho admin\n";
        } else {
            echo "❌ Mật khẩu admin123 không đúng\n";
        }
    } else {
        echo "❌ Không tìm thấy tài khoản admin\n";
    }
    
} catch (Exception $e) {
    echo "❌ Lỗi: " . $e->getMessage() . "\n";
}

echo "\n";

// 3. Test load admin controller
echo "3. Test load admin controller...\n";
try {
    require_once 'controllers/admin/DashboardController.php';
    echo "✅ Load DashboardController thành công\n";
    
    // Test tạo instance
    $dashboard = new admin\DashboardController();
    echo "✅ Tạo DashboardController instance thành công\n";
    
} catch (Exception $e) {
    echo "❌ Lỗi load controller: " . $e->getMessage() . "\n";
}

echo "\n";

// 4. Test các method cần thiết
echo "4. Test các method...\n";
try {
    require_once 'models/Post.php';
    require_once 'models/User.php';
    require_once 'models/Comment.php';
    require_once 'models/Category.php';
    
    $postModel = new Post();
    $userModel = new User();
    $commentModel = new Comment();
    $categoryModel = new Category();
    
    $totalPosts = $postModel->getTotalPosts();
    $totalUsers = $userModel->getTotalUsers();
    $totalComments = $commentModel->getTotalComments();
    $totalCategories = $categoryModel->getTotalCategories();
    
    echo "✅ Các method hoạt động:\n";
    echo "   - getTotalPosts(): $totalPosts\n";
    echo "   - getTotalUsers(): $totalUsers\n";
    echo "   - getTotalComments(): $totalComments\n";
    echo "   - getTotalCategories(): $totalCategories\n";
    
} catch (Exception $e) {
    echo "❌ Lỗi method: " . $e->getMessage() . "\n";
}

echo "\n";

// 5. Test view file
echo "5. Test view file...\n";
$viewFile = 'views/admin/dashboard.php';
if (file_exists($viewFile)) {
    echo "✅ View file tồn tại: $viewFile\n";
} else {
    echo "❌ View file không tồn tại: $viewFile\n";
}

echo "\n";

// 6. Hướng dẫn
echo "6. HƯỚNG DẪN:\n";
echo "   📝 Truy cập: http://localhost/Mini-4/public/login\n";
echo "   👤 Username: admin\n";
echo "   🔑 Password: admin123\n";
echo "   🎯 Sau khi đăng nhập: http://localhost/Mini-4/public/admin\n\n";

echo "=== HOÀN THÀNH TEST ===\n";
?>

