<?php
/**
 * Setup script for Mini-4 Blog/CMS
 * Run this script to create the database and tables
 */

echo "Mini-4 Blog/CMS Setup\n";
echo "======================\n\n";

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';

try {
    // Connect to MySQL without specifying database
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Connected to MySQL successfully\n";
    
    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS blog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✓ Database 'blog' created successfully\n";
    
    // Select the database
    $pdo->exec("USE blog");
    
    // Read and execute database.sql
    $sql = file_get_contents(__DIR__ . '/database.sql');
    
    // Split SQL into individual statements
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    foreach ($statements as $statement) {
        if (!empty($statement)) {
            $pdo->exec($statement);
        }
    }
    
    echo "✓ Database tables created successfully\n";
    
    // Insert sample data if sample_data.sql exists
    if (file_exists(__DIR__ . '/sample_data.sql')) {
        $sampleSql = file_get_contents(__DIR__ . '/sample_data.sql');
        $sampleStatements = array_filter(array_map('trim', explode(';', $sampleSql)));
        
        foreach ($sampleStatements as $statement) {
            if (!empty($statement)) {
                $pdo->exec($statement);
            }
        }
        
        echo "✓ Sample data inserted successfully\n";
    }
    
    echo "\n🎉 Setup completed successfully!\n";
    echo "You can now access your blog at: http://localhost/Mini-4/public/\n";
    echo "Admin panel: http://localhost/Mini-4/public/admin\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "\nPlease check your database configuration in config/database.php\n";
}
?> 