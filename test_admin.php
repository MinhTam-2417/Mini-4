<?php
// Script test để kiểm tra kết nối database và tạo admin
echo "=== TEST KẾT NỐI DATABASE VÀ TẠO ADMIN ===\n\n";

// 1. Test kết nối database
echo "1. Kiểm tra kết nối database...\n";
try {
    require_once 'config/database.php';
    $config = require 'config/database.php';
    
    $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
    $pdo = new PDO($dsn, $config['username'], $config['password'], $config['options']);
    
    echo "✅ Kết nối database thành công!\n";
    echo "   Host: {$config['host']}\n";
    echo "   Database: {$config['database']}\n";
    echo "   Username: {$config['username']}\n\n";
    
} catch (Exception $e) {
    echo "❌ Lỗi kết nối database: " . $e->getMessage() . "\n\n";
    exit;
}

// 2. Test các model
echo "2. Kiểm tra các model...\n";
try {
    require_once 'core/Model.php';
    require_once 'models/User.php';
    require_once 'models/Post.php';
    require_once 'models/Comment.php';
    require_once 'models/Category.php';
    
    echo "✅ Load các model thành công!\n\n";
    
} catch (Exception $e) {
    echo "❌ Lỗi load model: " . $e->getMessage() . "\n\n";
    exit;
}

// 3. Test tạo admin
echo "3. Kiểm tra tạo admin...\n";
try {
    $userModel = new User();
    
    // Kiểm tra xem admin đã tồn tại chưa
    $existingAdmin = $userModel->findByUsername('admin');
    
    if ($existingAdmin) {
        echo "✅ Tài khoản admin đã tồn tại!\n";
        echo "   Username: admin\n";
        echo "   Email: {$existingAdmin['email']}\n";
        echo "   Role: {$existingAdmin['role']}\n";
        echo "   ID: {$existingAdmin['id']}\n\n";
    } else {
        echo "❌ Tài khoản admin chưa tồn tại!\n";
        echo "   Đang tạo tài khoản admin...\n";
        
        $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $userId = $userModel->create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => $hashedPassword,
            'full_name' => 'Administrator',
            'role' => 'admin'
        ]);
        
        if ($userId) {
            echo "✅ Tạo tài khoản admin thành công!\n";
            echo "   Username: admin\n";
            echo "   Password: admin123\n";
            echo "   ID: {$userId}\n\n";
        } else {
            echo "❌ Lỗi tạo tài khoản admin!\n\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Lỗi kiểm tra admin: " . $e->getMessage() . "\n\n";
}

// 4. Test các method cần thiết cho dashboard
echo "4. Kiểm tra các method cho dashboard...\n";
try {
    $postModel = new Post();
    $userModel = new User();
    $commentModel = new Comment();
    $categoryModel = new Category();
    
    $totalPosts = $postModel->getTotalPosts();
    $totalUsers = $userModel->getTotalUsers();
    $totalComments = $commentModel->getTotalComments();
    $totalCategories = $categoryModel->getTotalCategories();
    
    echo "✅ Các method hoạt động bình thường!\n";
    echo "   Tổng bài viết: {$totalPosts}\n";
    echo "   Tổng người dùng: {$totalUsers}\n";
    echo "   Tổng bình luận: {$totalComments}\n";
    echo "   Tổng danh mục: {$totalCategories}\n\n";
    
} catch (Exception $e) {
    echo "❌ Lỗi method dashboard: " . $e->getMessage() . "\n\n";
}

// 5. Test session
echo "5. Kiểm tra session...\n";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo "✅ Session đã được khởi tạo!\n";
echo "   Session ID: " . session_id() . "\n\n";

// 6. Hướng dẫn đăng nhập
echo "6. HƯỚNG DẪN ĐĂNG NHẬP ADMIN:\n";
echo "   📝 Truy cập: http://localhost/Mini-4/public/login\n";
echo "   👤 Username: admin\n";
echo "   🔑 Password: admin123\n";
echo "   🎯 Sau khi đăng nhập sẽ được chuyển hướng đến: http://localhost/Mini-4/public/admin\n\n";

echo "=== HOÀN THÀNH KIỂM TRA ===\n";
?>

