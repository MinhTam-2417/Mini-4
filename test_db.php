<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=blog;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Database connection successful\n";
    
    // Check if tables exist
    $tables = ['users', 'categories', 'posts', 'comments'];
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "✓ Table '$table' exists\n";
        } else {
            echo "❌ Table '$table' does not exist\n";
        }
    }
    
    // Check sample data
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $userCount = $stmt->fetch()['count'];
    echo "Users count: $userCount\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM posts");
    $postCount = $stmt->fetch()['count'];
    echo "Posts count: $postCount\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM categories");
    $categoryCount = $stmt->fetch()['count'];
    echo "Categories count: $categoryCount\n";
    
    // Test a specific post query
    $stmt = $pdo->prepare("SELECT p.*, u.username as author_name, c.name as category_name 
                           FROM posts p 
                           LEFT JOIN users u ON p.user_id = u.id 
                           LEFT JOIN categories c ON p.category_id = c.id 
                           WHERE p.id = ? AND p.status = 'published'");
    $stmt->execute([1]);
    $post = $stmt->fetch();
    
    if ($post) {
        echo "✓ Post with ID 1 found: " . $post['title'] . "\n";
    } else {
        echo "❌ No post with ID 1 found\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?> 