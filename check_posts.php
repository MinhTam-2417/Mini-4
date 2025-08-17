<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "🔍 Kiểm tra posts trong database\n";

try {
    $config = require 'config/database.php';
    $pdo = new PDO("mysql:host=" . $config['host'] . ";dbname=" . $config['database'], $config['username'], $config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Kết nối database thành công\n";
    
    // Kiểm tra posts
    $result = $pdo->query("SELECT id, title, status FROM posts ORDER BY id LIMIT 10");
    $posts = $result->fetchAll(PDO::FETCH_ASSOC);
    
    echo "📊 Số lượng posts: " . count($posts) . "\n";
    
    if (!empty($posts)) {
        echo "Danh sách posts:\n";
        foreach ($posts as $post) {
            echo "- ID: {$post['id']}, Title: {$post['title']}, Status: {$post['status']}\n";
        }
    } else {
        echo "❌ Không có posts nào trong database\n";
    }
    
} catch (Exception $e) {
    echo "❌ Lỗi: " . $e->getMessage() . "\n";
}
?>


