<?php
session_start();

// Auto login for testing
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
    $_SESSION['username'] = 'admin';
    $_SESSION['role'] = 'admin';
}

// Load required files
require_once '../config/database.php';
require_once '../models/HiddenPost.php';

$config = require '../config/database.php';
$pdo = new PDO("mysql:host=" . $config['host'] . ";dbname=" . $config['database'], $config['username'], $config['password']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$hiddenPostModel = new HiddenPost();
$userId = $_SESSION['user_id'];

echo "<h2>🔍 Debug Hide Feature</h2>";

// Test 1: Check if user is logged in
echo "<h3>1. Session Check:</h3>";
echo "User ID: " . ($_SESSION['user_id'] ?? 'Not set') . "<br>";
echo "Username: " . ($_SESSION['username'] ?? 'Not set') . "<br>";
echo "Role: " . ($_SESSION['role'] ?? 'Not set') . "<br>";

// Test 2: Check database connection
echo "<h3>2. Database Connection:</h3>";
try {
    $result = $pdo->query("SELECT 1");
    echo "✅ Database connected successfully<br>";
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
}

// Test 3: Check if hidden_posts table exists
echo "<h3>3. Hidden Posts Table:</h3>";
try {
    $result = $pdo->query("SHOW TABLES LIKE 'hidden_posts'");
    if ($result->rowCount() > 0) {
        echo "✅ hidden_posts table exists<br>";
    } else {
        echo "❌ hidden_posts table does not exist<br>";
    }
} catch (Exception $e) {
    echo "❌ Error checking table: " . $e->getMessage() . "<br>";
}

// Test 4: Check existing hidden posts
echo "<h3>4. Existing Hidden Posts:</h3>";
try {
    $result = $pdo->query("SELECT * FROM hidden_posts LIMIT 5");
    $hiddenPosts = $result->fetchAll(PDO::FETCH_ASSOC);
    echo "Found " . count($hiddenPosts) . " hidden posts<br>";
    foreach ($hiddenPosts as $post) {
        echo "- User ID: {$post['user_id']}, Post ID: {$post['post_id']}, Hidden at: {$post['hidden_at']}<br>";
    }
} catch (Exception $e) {
    echo "❌ Error getting hidden posts: " . $e->getMessage() . "<br>";
}

// Test 5: Check available posts
echo "<h3>5. Available Posts:</h3>";
try {
    $result = $pdo->query("SELECT id, title FROM posts WHERE status = 'published' LIMIT 5");
    $posts = $result->fetchAll(PDO::FETCH_ASSOC);
    echo "Found " . count($posts) . " published posts<br>";
    foreach ($posts as $post) {
        echo "- ID: {$post['id']}, Title: {$post['title']}<br>";
    }
} catch (Exception $e) {
    echo "❌ Error getting posts: " . $e->getMessage() . "<br>";
}

// Test 6: Test hide functionality
echo "<h3>6. Test Hide Functionality:</h3>";
if (!empty($posts)) {
    $testPostId = $posts[0]['id'];
    echo "Testing with post ID: $testPostId<br>";
    
    // Check if already hidden
    $isHidden = $hiddenPostModel->isHidden($userId, $testPostId);
    echo "Is hidden: " . ($isHidden ? 'Yes' : 'No') . "<br>";
    
    // Try to hide
    if (!$isHidden) {
        $result = $hiddenPostModel->hidePost($userId, $testPostId);
        echo "Hide result: " . ($result ? 'Success' : 'Failed') . "<br>";
    } else {
        echo "Post is already hidden<br>";
    }
}

// Test 7: Check JavaScript
echo "<h3>7. JavaScript Test:</h3>";
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Hide Feature</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body data-logged-in="true">
    <div class="container mt-5">
        <h2>🧪 JavaScript Test</h2>
        
        <div class="alert alert-info">
            <strong>Test Instructions:</strong>
            <ul>
                <li>Click the hide button below</li>
                <li>Check browser console for errors</li>
                <li>Check network tab for AJAX requests</li>
            </ul>
        </div>
        
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Test Post</h5>
                <p class="card-text">This is a test post for debugging hide functionality.</p>
                
                <button class="hide-btn btn btn-sm btn-outline-warning" 
                        data-post-id="1" 
                        title="Ẩn bài viết">
                    <span class="hide-icon">
                        <i class="bi bi-eye"></i>
                    </span>
                </button>
                
                <button class="like-btn btn btn-sm btn-outline-danger" 
                        data-post-id="1" 
                        title="Thích">
                    <span class="like-icon">
                        <i class="bi bi-heart"></i>
                    </span>
                    <span class="ms-1">Thích</span>
                </button>
            </div>
        </div>
        
        <div class="mt-3">
            <a href="http://localhost/Mini-4/public/" class="btn btn-primary">🏠 Home Page</a>
            <a href="http://localhost/Mini-4/public/hidden-posts" class="btn btn-warning">👁️ Hidden Posts</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/Mini-4/public/js/like.js"></script>
    <script src="/Mini-4/public/js/hide.js"></script>
    
    <script>
    // Debug JavaScript
    console.log('Debug page loaded');
    console.log('User logged in:', document.body.dataset.loggedIn);
    
    // Test hide button click
    document.querySelector('.hide-btn').addEventListener('click', function() {
        console.log('Hide button clicked');
        console.log('Post ID:', this.dataset.postId);
    });
    
    // Test fetch
    fetch('/Mini-4/public/hide/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'post_id=1'
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
    })
    .catch(error => {
        console.error('Fetch error:', error);
    });
    </script>
</body>
</html>


