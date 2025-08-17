<?php
require_once __DIR__ . '/../core/Model.php';

class Like extends Model {
    public function __construct(){
        parent::__construct('likes');
    }

    // Thêm like cho bài viết
    public function addLike($userId, $postId) {
        try {
            $sql = "INSERT INTO {$this->table} (user_id, post_id) VALUES (?, ?)";
            return $this->db->execute($sql, [$userId, $postId]);
        } catch (Exception $e) {
            // Nếu đã like rồi thì bỏ qua lỗi duplicate
            return false;
        }
    }

    // Xóa like cho bài viết
    public function removeLike($userId, $postId) {
        $sql = "DELETE FROM {$this->table} WHERE user_id = ? AND post_id = ?";
        return $this->db->execute($sql, [$userId, $postId]);
    }

    // Kiểm tra user đã like bài viết chưa
    public function hasUserLiked($userId, $postId) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE user_id = ? AND post_id = ?";
        $result = $this->db->query($sql, [$userId, $postId]);
        return $result[0]['count'] > 0;
    }

    // Đếm số like của bài viết
    public function getLikeCount($postId) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE post_id = ?";
        $result = $this->db->query($sql, [$postId]);
        return $result[0]['count'] ?? 0;
    }

    // Lấy danh sách user đã like bài viết
    public function getUsersWhoLiked($postId) {
        $sql = "SELECT l.*, u.username, u.full_name 
                FROM {$this->table} l 
                JOIN users u ON l.user_id = u.id 
                WHERE l.post_id = ? 
                ORDER BY l.created_at DESC";
        return $this->db->query($sql, [$postId]);
    }

    // Toggle like (nếu đã like thì unlike, chưa like thì like)
    public function toggleLike($userId, $postId) {
        if ($this->hasUserLiked($userId, $postId)) {
            return $this->removeLike($userId, $postId);
        } else {
            return $this->addLike($userId, $postId);
        }
    }

    // Lấy tất cả likes với thông tin chi tiết (cho admin)
    public function getAllLikesWithDetails() {
        $sql = "SELECT l.*, u.username, u.full_name, p.title as post_title, p.slug as post_slug
                FROM {$this->table} l 
                JOIN users u ON l.user_id = u.id 
                JOIN posts p ON l.post_id = p.id 
                ORDER BY l.created_at DESC";
        return $this->db->query($sql);
    }

    // Lấy bài viết đã like bởi user (cho admin)
    public function getPostsLikedByUser($userId) {
        $sql = "SELECT l.*, p.title, p.slug, p.featured_image, p.excerpt, p.content, p.created_at as post_created_at, 
                       p.view_count, u.username as author_name
                FROM {$this->table} l 
                JOIN posts p ON l.post_id = p.id 
                LEFT JOIN users u ON p.user_id = u.id
                WHERE l.user_id = ? 
                ORDER BY l.created_at DESC";
        return $this->db->query($sql, [$userId]);
    }

    // Xóa like theo ID
    public function deleteById($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    // Thống kê likes
    public function getStats() {
        $stats = [];
        
        // Tổng số lượt like
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $result = $this->db->query($sql);
        $stats['total_likes'] = $result[0]['total'];
        
        // Số user đã like
        $sql = "SELECT COUNT(DISTINCT user_id) as total FROM {$this->table}";
        $result = $this->db->query($sql);
        $stats['total_users'] = $result[0]['total'];
        
        // Số bài viết được like
        $sql = "SELECT COUNT(DISTINCT post_id) as total FROM {$this->table}";
        $result = $this->db->query($sql);
        $stats['total_posts'] = $result[0]['total'];
        
        // Top 5 bài viết nhiều like nhất
        $sql = "SELECT p.title, p.slug, COUNT(l.id) as like_count
                FROM posts p 
                LEFT JOIN {$this->table} l ON p.id = l.post_id 
                GROUP BY p.id 
                ORDER BY like_count DESC 
                LIMIT 5";
        $stats['top_posts'] = $this->db->query($sql);
        
        // Top 5 user like nhiều nhất
        $sql = "SELECT u.username, u.full_name, COUNT(l.id) as like_count
                FROM users u 
                LEFT JOIN {$this->table} l ON u.id = l.user_id 
                GROUP BY u.id 
                ORDER BY like_count DESC 
                LIMIT 5";
        $stats['top_users'] = $this->db->query($sql);
        
        return $stats;
    }
}
?>
