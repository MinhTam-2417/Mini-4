<?php
echo "Testing database configuration...\n";

$configPath = __DIR__ . '/config/database.php';
echo "Config path: " . $configPath . "\n";
echo "File exists: " . (file_exists($configPath) ? 'Yes' : 'No') . "\n";

if (file_exists($configPath)) {
    $config = require_once $configPath;
    echo "Config loaded: " . (is_array($config) ? 'Yes' : 'No') . "\n";
    echo "Config content: " . var_export($config, true) . "\n";
    
    if (is_array($config)) {
        echo "Testing database connection...\n";
        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
            $pdo = new PDO($dsn, $config['username'], $config['password'], $config['options']);
            echo "Database connection successful!\n";
        } catch (PDOException $e) {
            echo "Database connection failed: " . $e->getMessage() . "\n";
        }
    }
}
?> 