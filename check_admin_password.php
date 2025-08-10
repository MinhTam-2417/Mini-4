<?php
// Script kiểm tra mật khẩu admin
require_once 'config/database.php';
require_once 'core/Model.php';
require_once 'models/User.php';

echo "=== KIỂM TRA MẬT KHẨU ADMIN ===\n\n";

try {
    $userModel = new User();
    $admin = $userModel->findByUsername('admin');
    
    if ($admin) {
        echo "✅ Tìm thấy tài khoản admin:\n";
        echo "   ID: {$admin['id']}\n";
        echo "   Username: {$admin['username']}\n";
        echo "   Email: {$admin['email']}\n";
        echo "   Role: {$admin['role']}\n";
        echo "   Password Hash: {$admin['password']}\n\n";
        
        // Test các mật khẩu
        $passwords = ['admin123', 'password', 'admin', '123456', 'password123'];
        
        echo "🔍 Kiểm tra các mật khẩu:\n";
        foreach ($passwords as $password) {
            if (password_verify($password, $admin['password'])) {
                echo "   ✅ '$password' - ĐÚNG\n";
            } else {
                echo "   ❌ '$password' - SAI\n";
            }
        }
        
        echo "\n";
        
        // Tạo mật khẩu mới
        echo "🔄 Tạo mật khẩu mới 'admin123':\n";
        $newHash = password_hash('admin123', PASSWORD_DEFAULT);
        echo "   Hash mới: $newHash\n";
        
        // Cập nhật mật khẩu
        echo "\n📝 Cập nhật mật khẩu trong database...\n";
        $userModel->updatePassword($admin['id'], $newHash);
        echo "   ✅ Đã cập nhật mật khẩu!\n";
        
        // Kiểm tra lại
        echo "\n🔍 Kiểm tra lại mật khẩu 'admin123':\n";
        $updatedAdmin = $userModel->findByUsername('admin');
        if (password_verify('admin123', $updatedAdmin['password'])) {
            echo "   ✅ Mật khẩu 'admin123' giờ đã đúng!\n";
        } else {
            echo "   ❌ Vẫn sai!\n";
        }
        
    } else {
        echo "❌ Không tìm thấy tài khoản admin!\n";
    }
    
} catch (Exception $e) {
    echo "❌ Lỗi: " . $e->getMessage() . "\n";
}

echo "\n=== HOÀN THÀNH ===\n";
?>

