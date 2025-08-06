<?php
require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/Model.php';
require_once __DIR__ . '/models/Post.php';

try {
    echo "Testing Post model...\n";
    
    $postModel = new Post();
    
    // Test findWithDetails
    echo "Testing findWithDetails(1)...\n";
    $post = $postModel->findWithDetails(1);
    
    if ($post) {
        echo "✓ Post found: " . $post['title'] . "\n";
        echo "Author: " . $post['author_name'] . "\n";
        echo "Category: " . $post['category_name'] . "\n";
    } else {
        echo "❌ Post not found\n";
    }
    
    // Test getRelatedPosts
    echo "\nTesting getRelatedPosts...\n";
    $relatedPosts = $postModel->getRelatedPosts(1, 1, 3);
    echo "Related posts count: " . count($relatedPosts) . "\n";
    
    // Test getAllPublished
    echo "\nTesting getAllPublished...\n";
    $allPosts = $postModel->getAllPublished();
    echo "All published posts count: " . count($allPosts) . "\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
?> 