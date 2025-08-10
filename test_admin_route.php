<?php
// Script test để kiểm tra route admin
session_start();

echo "=== TEST ADMIN ROUTE ===\n\n";

// Set session cho admin
$_SESSION['user_id'] = 1;
$_SESSION['username'] = 'admin';
$_SESSION['role'] = 'admin';

echo "1. Session đã set cho admin:\n";
echo "   user_id: {$_SESSION['user_id']}\n";
echo "   username: {$_SESSION['username']}\n";
echo "   role: {$_SESSION['role']}\n\n";

// 2. Test load Router
echo "2. Test load Router...\n";
try {
    require_once 'core/Router.php';
    echo "✅ Router loaded\n";
} catch (Exception $e) {
    echo "❌ Lỗi Router: " . $e->getMessage() . "\n";
}

// 3. Test load DashboardController
echo "\n3. Test load DashboardController...\n";
try {
    require_once 'controllers/admin/DashboardController.php';
    echo "✅ DashboardController loaded\n";
    
    // Test tạo instance
    $dashboard = new admin\DashboardController();
    echo "✅ DashboardController instance created\n";
    
    // Test method index
    echo "✅ Testing index method...\n";
    ob_start();
    $dashboard->index();
    $output = ob_get_clean();
    echo "✅ Index method executed successfully\n";
    
} catch (Exception $e) {
    echo "❌ Lỗi DashboardController: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

// 4. Test các model methods
echo "\n4. Test model methods...\n";
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
    
    echo "✅ Model methods work:\n";
    echo "   - getTotalPosts(): $totalPosts\n";
    echo "   - getTotalUsers(): $totalUsers\n";
    echo "   - getTotalComments(): $totalComments\n";
    echo "   - getTotalCategories(): $totalCategories\n";
    
} catch (Exception $e) {
    echo "❌ Lỗi model: " . $e->getMessage() . "\n";
}

// 5. Test view file
echo "\n5. Test view file...\n";
$viewFile = 'views/admin/dashboard.php';
if (file_exists($viewFile)) {
    echo "✅ View file exists: $viewFile\n";
    
    // Test include view
    try {
        ob_start();
        include $viewFile;
        $viewOutput = ob_get_clean();
        echo "✅ View file can be included\n";
        echo "   Output length: " . strlen($viewOutput) . " characters\n";
    } catch (Exception $e) {
        echo "❌ Lỗi include view: " . $e->getMessage() . "\n";
    }
} else {
    echo "❌ View file not found: $viewFile\n";
}

echo "\n=== HOÀN THÀNH TEST ===\n";
?>

