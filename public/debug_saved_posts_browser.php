<?php
session_start();

echo "<h2>🔍 Debug Saved Posts Browser Test</h2>";

// Check session
echo "<h3>📋 Session Status:</h3>";
if (isset($_SESSION['user_id'])) {
    echo "✅ <strong>User logged in:</strong> ID = " . $_SESSION['user_id'] . "<br>";
    echo "✅ <strong>Username:</strong> " . ($_SESSION['username'] ?? 'N/A') . "<br>";
    echo "✅ <strong>Role:</strong> " . ($_SESSION['role'] ?? 'N/A') . "<br>";
} else {
    echo "❌ <strong>User not logged in!</strong><br>";
    
    // Auto login for testing
    $_SESSION['user_id'] = 1;
    $_SESSION['username'] = 'admin';
    $_SESSION['role'] = 'admin';
    echo "🔑 <strong>Auto-logged in as admin for testing</strong><br>";
}

// Test Router dispatch
echo "<h3>🔧 Testing Router Dispatch:</h3>";

try {
    // Simulate the exact request
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/Mini-4/public/saved-posts';
    
    echo "✅ <strong>Request method:</strong> " . $_SERVER['REQUEST_METHOD'] . "<br>";
    echo "✅ <strong>Request URI:</strong> " . $_SERVER['REQUEST_URI'] . "<br>";
    
    // Test Router
    require_once '../core/Router.php';
    $router = new Router();
    
    // Add the route
    $router->addRouter('GET', '/saved-posts', 'client/SaveShareController@savedPosts');
    
    echo "✅ <strong>Router created and route added</strong><br>";
    
    // Test if we can create controller manually
    require_once '../controllers/client/SaveShareController.php';
    $controller = new client\SaveShareController();
    echo "✅ <strong>Controller created manually</strong><br>";
    
    // Test if method exists
    if (method_exists($controller, 'savedPosts')) {
        echo "✅ <strong>Method exists:</strong> savedPosts()<br>";
    } else {
        echo "❌ <strong>Method not found!</strong> savedPosts()<br>";
    }
    
    // Test data retrieval
    require_once '../models/SavedPost.php';
    $savedPostModel = new SavedPost();
    
    $userId = $_SESSION['user_id'];
    $savedPosts = $savedPostModel->getSavedPostsByUser($userId, 10, 0);
    $totalCount = $savedPostModel->countSavedPostsByUser($userId);
    
    echo "✅ <strong>Data retrieved:</strong><br>";
    echo "- User ID: " . $userId . "<br>";
    echo "- Saved posts: " . count($savedPosts) . "<br>";
    echo "- Total count: " . $totalCount . "<br>";
    
    if (!empty($savedPosts)) {
        echo "<h4>📝 Sample posts:</h4>";
        foreach (array_slice($savedPosts, 0, 3) as $post) {
            echo "📄 " . htmlspecialchars($post['title']) . "<br>";
        }
    }
    
    // Test view method
    echo "<h3>🎨 Testing View Method:</h3>";
    
    // Check if view method exists in Controller
    if (method_exists($controller, 'view')) {
        echo "✅ <strong>View method exists in Controller</strong><br>";
    } else {
        echo "❌ <strong>View method not found in Controller!</strong><br>";
    }
    
    // Check if view file exists
    $viewFile = '../views/client/saved_posts.php';
    if (file_exists($viewFile)) {
        echo "✅ <strong>View file exists:</strong> $viewFile<br>";
        
        // Check if layout file exists
        $layoutFile = '../views/client/layout/main.php';
        if (file_exists($layoutFile)) {
            echo "✅ <strong>Layout file exists:</strong> $layoutFile<br>";
        } else {
            echo "❌ <strong>Layout file not found!</strong> $layoutFile<br>";
        }
        
    } else {
        echo "❌ <strong>View file not found!</strong> $viewFile<br>";
    }
    
    // Test Controller method directly
    echo "<h3>🎯 Testing Controller Method Directly:</h3>";
    
    // Set GET parameter
    $_GET['page'] = 1;
    
    // Call the method directly
    echo "🔄 <strong>Calling savedPosts() method...</strong><br>";
    
    // Start output buffering to capture any output
    ob_start();
    
    try {
        $controller->savedPosts();
        $output = ob_get_clean();
        
        echo "✅ <strong>Method executed successfully</strong><br>";
        echo "📄 <strong>Output length:</strong> " . strlen($output) . " characters<br>";
        
        if (strlen($output) > 0) {
            echo "✅ <strong>Output generated!</strong><br>";
            echo "<h4>📄 Output Preview:</h4>";
            echo "<div style='background: #f8f9fa; padding: 10px; border: 1px solid #ddd; max-height: 200px; overflow-y: auto;'>";
            echo htmlspecialchars(substr($output, 0, 500)) . "...";
            echo "</div>";
        } else {
            echo "⚠️ <strong>No output generated!</strong><br>";
        }
        
    } catch (Exception $e) {
        ob_end_clean();
        echo "❌ <strong>Method execution failed:</strong> " . htmlspecialchars($e->getMessage()) . "<br>";
        echo "📍 <strong>File:</strong> " . $e->getFile() . "<br>";
        echo "📍 <strong>Line:</strong> " . $e->getLine() . "<br>";
    }
    
} catch (Exception $e) {
    echo "❌ <strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "<br>";
    echo "📍 <strong>File:</strong> " . $e->getFile() . "<br>";
    echo "📍 <strong>Line:</strong> " . $e->getLine() . "<br>";
}

echo "<h3>🎯 Possible Issues:</h3>";
echo "1. <strong>Session not persisting in browser</strong> - Check cookies<br>";
echo "2. <strong>Router not dispatching correctly</strong> - Check URL matching<br>";
echo "3. <strong>Controller method throwing error</strong> - Check error logs<br>";
echo "4. <strong>View not rendering</strong> - Check template files<br>";
echo "5. <strong>Layout not loading</strong> - Check layout file<br>";

echo "<h3>🔗 Test Links:</h3>";
echo "<a href='http://localhost/Mini-4/public/saved-posts' target='_blank' style='background: #28a745; color: white; padding: 10px; text-decoration: none; border-radius: 5px; margin: 5px; display: inline-block;'>📚 Test Saved Posts Page</a> ";
echo "<a href='http://localhost/Mini-4/public/test_simple_saved.php' target='_blank' style='background: #007bff; color: white; padding: 10px; text-decoration: none; border-radius: 5px; margin: 5px; display: inline-block;'>🧪 Test Simple Page</a> ";
echo "<a href='http://localhost/Mini-4/public/' target='_blank' style='background: #6c757d; color: white; padding: 10px; text-decoration: none; border-radius: 5px; margin: 5px; display: inline-block;'>🏠 Home Page</a>";

echo "<h3>💡 Next Steps:</h3>";
echo "1. <strong>Check browser console</strong> for JavaScript errors<br>";
echo "2. <strong>Check browser network tab</strong> for failed requests<br>";
echo "3. <strong>Check server error logs</strong> for PHP errors<br>";
echo "4. <strong>Try hard refresh</strong> (Ctrl+F5)<br>";
echo "5. <strong>Clear browser cache</strong> and try again<br>";
?>


