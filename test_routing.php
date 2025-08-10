<?php
// Script test để mô phỏng routing cho admin
session_start();

echo "=== TEST ROUTING ADMIN ===\n\n";

// Set session cho admin
$_SESSION['user_id'] = 1;
$_SESSION['username'] = 'admin';
$_SESSION['role'] = 'admin';

echo "1. Session set cho admin\n\n";

// 2. Test Router với URL admin
echo "2. Test Router với URL /admin...\n";

try {
    require_once 'core/Router.php';
    require_once 'config/database.php';
    
    $router = new Router();
    
    // Thêm route admin
    $router->addRouter('GET', '/admin', 'admin\\DashboardController@index');
    
    echo "✅ Router created và route added\n";
    
    // Test dispatch với URL /admin
    echo "✅ Testing dispatch với URI: /admin\n";
    
    // Mô phỏng $_SERVER
    $_SERVER['REQUEST_URI'] = '/Mini-4/public/admin';
    $_SERVER['REQUEST_METHOD'] = 'GET';
    
    echo "   REQUEST_URI: {$_SERVER['REQUEST_URI']}\n";
    echo "   REQUEST_METHOD: {$_SERVER['REQUEST_METHOD']}\n";
    
    // Test dispatch
    ob_start();
    $router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    $output = ob_get_clean();
    
    echo "✅ Dispatch completed\n";
    echo "   Output length: " . strlen($output) . " characters\n";
    
    if (strlen($output) > 100) {
        echo "   Output preview: " . substr($output, 0, 100) . "...\n";
    }
    
} catch (Exception $e) {
    echo "❌ Lỗi routing: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== HOÀN THÀNH TEST ROUTING ===\n";
?>

