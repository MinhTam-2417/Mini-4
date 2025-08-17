<?php
require_once 'config/database.php';
require_once 'core/Database.php';

$db = new Database();

echo "=== THÊM DỮ LIỆU MẪU CHO TAGS ===\n\n";

$sampleTags = [
    ['name' => 'Công nghệ', 'slug' => 'cong-nghe', 'description' => 'Các bài viết về công nghệ, phần mềm, và phát triển', 'color' => '#007bff'],
    ['name' => 'Giải trí', 'slug' => 'giai-tri', 'description' => 'Nội dung giải trí, phim ảnh, âm nhạc', 'color' => '#28a745'],
    ['name' => 'Thể thao', 'slug' => 'the-thao', 'description' => 'Tin tức thể thao, bóng đá, các môn thể thao khác', 'color' => '#dc3545'],
    ['name' => 'Du lịch', 'slug' => 'du-lich', 'description' => 'Kinh nghiệm du lịch, địa điểm đẹp', 'color' => '#ffc107'],
    ['name' => 'Ẩm thực', 'slug' => 'am-thuc', 'description' => 'Công thức nấu ăn, món ngon', 'color' => '#fd7e14'],
    ['name' => 'Sức khỏe', 'slug' => 'suc-khoe', 'description' => 'Chăm sóc sức khỏe, dinh dưỡng', 'color' => '#6f42c1'],
    ['name' => 'Giáo dục', 'slug' => 'giao-duc', 'description' => 'Kiến thức, học tập, giáo dục', 'color' => '#20c997'],
    ['name' => 'Kinh doanh', 'slug' => 'kinh-doanh', 'description' => 'Tin tức kinh doanh, tài chính', 'color' => '#6c757d'],
    ['name' => 'Thời trang', 'slug' => 'thoi-trang', 'description' => 'Xu hướng thời trang, làm đẹp', 'color' => '#e83e8c'],
    ['name' => 'Xe cộ', 'slug' => 'xe-co', 'description' => 'Tin tức xe hơi, xe máy', 'color' => '#495057']
];

foreach ($sampleTags as $tag) {
    try {
        $db->execute("INSERT INTO tags (name, slug, description, color) VALUES (?, ?, ?, ?)", 
                    [$tag['name'], $tag['slug'], $tag['description'], $tag['color']]);
        echo "✓ Thêm tag: {$tag['name']}\n";
    } catch (Exception $e) {
        echo "- Lỗi khi thêm tag {$tag['name']}: " . $e->getMessage() . "\n";
    }
}

echo "\n=== HOÀN THÀNH ===\n";

// Kiểm tra kết quả
$tags = $db->query("SELECT * FROM tags ORDER BY id");
echo "\nTổng số tags: " . count($tags) . "\n";
foreach ($tags as $tag) {
    echo "- ID: {$tag['id']}, Tên: {$tag['name']}, Màu: {$tag['color']}\n";
}
?>


