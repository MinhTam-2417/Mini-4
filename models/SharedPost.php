<?php
require_once __DIR__ . '/../core/Model.php';

class SharedPost extends Model {
    public function __construct() {
        parent::__construct('shared_posts');
    }

    // Ghi lại lượt chia sẻ
    public function recordShare($userId, $postId, $shareType) {
        $sql = "INSERT INTO {$this->table} (user_id, post_id, share_type) VALUES (?, ?, ?)";
        return $this->db->execute($sql, [$userId, $postId, $shareType]);
    }

    // Lấy số lượt chia sẻ của bài viết
    public function getShareCount($postId) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE post_id = ?";
        $result = $this->db->query($sql, [$postId]);
        return $result ? $result[0]['count'] : 0;
    }

    // Lấy số lượt chia sẻ theo loại
    public function getShareCountByType($postId, $shareType) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE post_id = ? AND share_type = ?";
        $result = $this->db->query($sql, [$postId, $shareType]);
        return $result ? $result[0]['count'] : 0;
    }

    // Lấy thống kê chia sẻ của bài viết
    public function getShareStats($postId) {
        $sql = "SELECT share_type, COUNT(*) as count 
                FROM {$this->table} 
                WHERE post_id = ? 
                GROUP BY share_type";
        return $this->db->query($sql, [$postId]);
    }

    // Lấy danh sách bài viết được chia sẻ nhiều nhất
    public function getMostSharedPosts($limit = 10) {
        $sql = "SELECT p.*, u.username as author_name, c.name as category_name, 
                       COUNT(sp.id) as share_count
                FROM posts p
                LEFT JOIN users u ON p.user_id = u.id
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN {$this->table} sp ON p.id = sp.post_id
                WHERE p.status = 'published'
                GROUP BY p.id
                ORDER BY share_count DESC
                LIMIT " . (int)$limit;
        return $this->db->query($sql);
    }

    // Lấy lịch sử chia sẻ của user
    public function getShareHistoryByUser($userId, $limit = 10, $offset = 0) {
        $sql = "SELECT p.*, u.username as author_name, c.name as category_name, 
                       sp.share_type, sp.shared_at
                FROM {$this->table} sp
                LEFT JOIN posts p ON sp.post_id = p.id
                LEFT JOIN users u ON p.user_id = u.id
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE sp.user_id = ? AND p.status = 'published'
                ORDER BY sp.shared_at DESC
                LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
        return $this->db->query($sql, [$userId]);
    }
}
