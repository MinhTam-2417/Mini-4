<?php
echo "Bắt đầu debug...\n";

require_once 'config/database.php';
echo "✓ Config loaded\n";

require_once 'core/Model.php';
echo "✓ Model loaded\n";

require_once 'models/Post.php';
echo "✓ Post model loaded\n";

$postModel = new Post();
echo "✓ Post model instance created\n";

// Test bài viết ID 24
$postId = 24;
echo "Testing post ID: {$postId}\n";

$post = $postModel->findWithLikeInfo($postId, null);
echo "Query completed\n";

if ($post) {
    echo "✓ Post found\n";
    echo "Title: " . ($post['title'] ?? 'N/A') . "\n";
    echo "Author: " . ($post['author_name'] ?? 'N/A') . "\n";
    echo "Category: " . ($post['category_name'] ?? 'N/A') . "\n";
    echo "Status: " . ($post['status'] ?? 'N/A') . "\n";
} else {
    echo "✗ Post not found\n";
}

echo "Debug completed\n";
?>


