<?php
require_once 'config/database.php';
require_once 'core/Database.php';

$db = new Database();

echo "=== CẬP NHẬT CẤU TRÚC BẢNG TAGS ===\n\n";

try {
    // Thêm cột description nếu chưa có
    echo "1. Thêm cột description...\n";
    $db->execute("ALTER TABLE tags ADD COLUMN description TEXT AFTER slug");
    echo "   ✓ Thành công\n";
} catch (Exception $e) {
    echo "   - Cột description đã tồn tại hoặc có lỗi: " . $e->getMessage() . "\n";
}

try {
    // Thêm cột color nếu chưa có
    echo "2. Thêm cột color...\n";
    $db->execute("ALTER TABLE tags ADD COLUMN color VARCHAR(7) DEFAULT '#007bff' AFTER description");
    echo "   ✓ Thành công\n";
} catch (Exception $e) {
    echo "   - Cột color đã tồn tại hoặc có lỗi: " . $e->getMessage() . "\n";
}

try {
    // Thêm cột updated_at nếu chưa có
    echo "3. Thêm cột updated_at...\n";
    $db->execute("ALTER TABLE tags ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at");
    echo "   ✓ Thành công\n";
} catch (Exception $e) {
    echo "   - Cột updated_at đã tồn tại hoặc có lỗi: " . $e->getMessage() . "\n";
}

// Kiểm tra cấu trúc mới
echo "\n4. Cấu trúc bảng tags sau khi cập nhật:\n";
$columns = $db->query("DESCRIBE tags");
foreach ($columns as $column) {
    echo "   - {$column['Field']}: {$column['Type']}\n";
}

echo "\n=== HOÀN THÀNH ===\n";
?>


