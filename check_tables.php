<?php
require_once 'config/database.php';
require_once 'core/Database.php';

$db = new Database();

echo "=== KIỂM TRA BẢNG TAGS ===\n\n";

// Kiểm tra bảng tags có tồn tại không
$tables = $db->query("SHOW TABLES LIKE 'tags'");
echo "1. Bảng tags: " . (empty($tables) ? "KHÔNG TỒN TẠI" : "ĐÃ TỒN TẠI") . "\n";

if (!empty($tables)) {
    // Kiểm tra cấu trúc bảng tags
    $columns = $db->query("DESCRIBE tags");
    echo "2. Cấu trúc bảng tags:\n";
    foreach ($columns as $column) {
        echo "   - {$column['Field']}: {$column['Type']}\n";
    }
    
    // Kiểm tra dữ liệu
    $tags = $db->query("SELECT * FROM tags LIMIT 5");
    echo "3. Số lượng tags: " . count($tags) . "\n";
    if (!empty($tags)) {
        echo "   Tags đầu tiên:\n";
        foreach ($tags as $tag) {
            echo "   - ID: {$tag['id']}, Tên: {$tag['name']}\n";
        }
    }
}

// Kiểm tra bảng post_tags
$postTags = $db->query("SHOW TABLES LIKE 'post_tags'");
echo "\n4. Bảng post_tags: " . (empty($postTags) ? "KHÔNG TỒN TẠI" : "ĐÃ TỒN TẠI") . "\n";

if (!empty($postTags)) {
    $columns = $db->query("DESCRIBE post_tags");
    echo "5. Cấu trúc bảng post_tags:\n";
    foreach ($columns as $column) {
        echo "   - {$column['Field']}: {$column['Type']}\n";
    }
}
?>


