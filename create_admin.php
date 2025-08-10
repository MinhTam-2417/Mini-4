<?php
// Script tạo tài khoản admin
require_once 'config/database.php';
require_once 'core/Model.php';
require_once 'models/User.php';

// Thông tin admin mẫu
$adminData = [
    'username' => 'admin',
    'email' => 'admin@example.com',
    'password' => 'admin123',
    'full_name' => 'Administrator',
    'role' => 'admin'
];

try {
    $userModel = new User();
    
    // Kiểm tra xem admin đã tồn tại chưa
    $existingAdmin = $userModel->findByUsername($adminData['username']);
    
    if ($existingAdmin) {
        echo "Tài khoản admin đã tồn tại!\n";
        echo "Username: " . $adminData['username'] . "\n";
        echo "Password: " . $adminData['password'] . "\n";
    } else {
        // Tạo admin mới
        $hashedPassword = password_hash($adminData['password'], PASSWORD_DEFAULT);
        $userId = $userModel->create([
            'username' => $adminData['username'],
            'email' => $adminData['email'],
            'password' => $hashedPassword,
            'full_name' => $adminData['full_name'],
            'role' => $adminData['role']
        ]);
        
        if ($userId) {
            echo "Tạo tài khoản admin thành công!\n";
            echo "Username: " . $adminData['username'] . "\n";
            echo "Password: " . $adminData['password'] . "\n";
            echo "Email: " . $adminData['email'] . "\n";
            echo "Role: " . $adminData['role'] . "\n";
            echo "\nBạn có thể đăng nhập tại: /Mini-4/public/login\n";
        } else {
            echo "Có lỗi xảy ra khi tạo tài khoản admin!\n";
        }
    }
    
} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage() . "\n";
}
?>
