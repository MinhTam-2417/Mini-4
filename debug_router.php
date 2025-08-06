<?php
echo "Debug Router\n";
echo "============\n\n";

// Simulate the same logic as Router
$uri = '/Mini-4/public/logout';
$method = 'GET';

echo "Original URI: $uri\n";
echo "Method: $method\n\n";

// Parse URL
$uri = parse_url($uri, PHP_URL_PATH);
echo "Parsed URI: $uri\n";

// Remove /Mini-4/public
$uri = preg_replace('#^/Mini-4/public#', '', $uri);
echo "After removing /Mini-4/public: $uri\n\n";

// Test pattern matching
$pattern = '/logout';
$matches = [];
if (preg_match("#^{$pattern}$#", $uri, $matches)) {
    echo "✓ Pattern matched!\n";
    echo "Matches: " . print_r($matches, true) . "\n";
} else {
    echo "❌ Pattern did not match\n";
}

// Test controller file
$controller = 'client/AuthController';
$controllerFile = __DIR__ . "/controllers/$controller.php";
echo "\nController file: $controllerFile\n";
echo "File exists: " . (file_exists($controllerFile) ? 'Yes' : 'No') . "\n";

// Test action
$action = 'logout';
echo "Action: $action\n";

// Test class creation
$controllerParts = explode('/', $controller);
$controllerClass = end($controllerParts);
$controllerClass = 'client\\' . $controllerClass;
echo "Controller class: $controllerClass\n";
?> 