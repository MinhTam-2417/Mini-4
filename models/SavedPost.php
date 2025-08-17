<?php
require_once __DIR__ . '/../core/Model.php';

class SavedPost extends Model {
    public function __construct() {
        parent::__construct('saved_posts');
    }

    // Lưu bài viết
    public function savePost($userId, $postId) {
        try {
            $sql = "INSERT INTO {$this->table} (user_id, post_id) VALUES (?, ?)";
            return $this->db->execute($sql, [$userId, $postId]);
        } catch (Exception $e) {
            // Nếu đã lưu rồi thì bỏ qua
            return false;
        }
    }

    // Bỏ lưu bài viết
    public function unsavePost($userId, $postId) {
        $sql = "DELETE FROM {$this->table} WHERE user_id = ? AND post_id = ?";
        return $this->db->execute($sql, [$userId, $postId]);
    }

    // Kiểm tra user đã lưu bài viết chưa
    public function isSaved($userId, $postId) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE user_id = ? AND post_id = ?";
        $result = $this->db->query($sql, [$userId, $postId]);
        return $result && $result[0]['count'] > 0;
    }

    // Lấy danh sách bài viết đã lưu của user
    public function getSavedPostsByUser($userId, $limit = 10, $offset = 0) {
        $sql = "SELECT p.*, u.username as author_name, c.name as category_name, sp.created_at as saved_at
                FROM {$this->table} sp
                LEFT JOIN posts p ON sp.post_id = p.id
                LEFT JOIN users u ON p.user_id = u.id
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE sp.user_id = ? AND p.status = 'published'
                ORDER BY sp.created_at DESC
                LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
        return $this->db->query($sql, [$userId]);
    }

    // Đếm số bài viết đã lưu của user
    public function countSavedPostsByUser($userId) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} sp
                LEFT JOIN posts p ON sp.post_id = p.id
                WHERE sp.user_id = ? AND p.status = 'published'";
        $result = $this->db->query($sql, [$userId]);
        return $result ? $result[0]['count'] : 0;
    }

    // Lấy số lượt lưu của bài viết
    public function getSaveCount($postId) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE post_id = ?";
        $result = $this->db->query($sql, [$postId]);
        return $result ? $result[0]['count'] : 0;
    }
}
