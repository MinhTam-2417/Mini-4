<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "🔍 Kiểm tra bảng hidden_posts\n";

try {
    $config = require 'config/database.php';
    $pdo = new PDO("mysql:host=" . $config['host'] . ";dbname=" . $config['database'], $config['username'], $config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Kết nối database thành công\n";
    
    // Kiểm tra bảng hidden_posts
    $result = $pdo->query("SHOW TABLES LIKE 'hidden_posts'");
    if ($result->rowCount() > 0) {
        echo "✅ Bảng hidden_posts đã tồn tại\n";
        
        // Kiểm tra dữ liệu
        $result = $pdo->query("SELECT COUNT(*) as count FROM hidden_posts");
        $count = $result->fetch(PDO::FETCH_ASSOC)['count'];
        echo "📊 Số lượng bản ghi: $count\n";
        
    } else {
        echo "❌ Bảng hidden_posts chưa tồn tại\n";
        echo "Đang tạo bảng...\n";
        
        $sql = "CREATE TABLE hidden_posts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            post_id INT NOT NULL,
            hidden_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY unique_user_post (user_id, post_id),
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
        )";
        
        $pdo->exec($sql);
        echo "✅ Đã tạo bảng hidden_posts thành công\n";
    }
    
} catch (Exception $e) {
    echo "❌ Lỗi: " . $e->getMessage() . "\n";
}
?>


