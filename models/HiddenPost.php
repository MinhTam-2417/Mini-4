<?php

require_once __DIR__ . '/../core/Model.php';

class HiddenPost extends Model {
    
    public function __construct() {
        parent::__construct('hidden_posts');
    }
    
    // Ẩn bài viết
    public function hidePost($userId, $postId) {
        try {
            // Kiểm tra xem đã ẩn chưa
            $existing = $this->db->query("SELECT id FROM hidden_posts WHERE user_id = ? AND post_id = ?", [$userId, $postId]);
            
            if (!empty($existing)) {
                return false; // Đã ẩn rồi
            }
            
            // Thêm vào bảng hidden_posts
            return $this->db->execute("INSERT INTO hidden_posts (user_id, post_id, hidden_at) VALUES (?, ?, NOW())", [$userId, $postId]);
            
        } catch (Exception $e) {
            error_log("Error hiding post: " . $e->getMessage());
            return false;
        }
    }
    
    // Hiện bài viết
    public function unhidePost($userId, $postId) {
        try {
            return $this->db->execute("DELETE FROM hidden_posts WHERE user_id = ? AND post_id = ?", [$userId, $postId]);
            
        } catch (Exception $e) {
            error_log("Error unhiding post: " . $e->getMessage());
            return false;
        }
    }
    
    // Kiểm tra bài viết có bị ẩn không
    public function isHidden($userId, $postId) {
        try {
            $result = $this->db->query("SELECT id FROM hidden_posts WHERE user_id = ? AND post_id = ?", [$userId, $postId]);
            return !empty($result);
            
        } catch (Exception $e) {
            error_log("Error checking hidden post: " . $e->getMessage());
            return false;
        }
    }
    
    // Lấy danh sách bài viết bị ẩn của user
    public function getHiddenPostsByUser($userId, $limit = 10, $offset = 0) {
        try {
            // Đảm bảo limit và offset là integer
            $limit = (int)$limit;
            $offset = (int)$offset;
            
            $sql = "SELECT p.*, u.username as author_name, u.full_name as author_full_name,
                           c.name as category_name, hp.hidden_at
                    FROM hidden_posts hp
                    JOIN posts p ON hp.post_id = p.id
                    LEFT JOIN users u ON p.user_id = u.id
                    LEFT JOIN categories c ON p.category_id = c.id
                    WHERE hp.user_id = ? AND p.status = 'published'
                    ORDER BY hp.hidden_at DESC
                    LIMIT $limit OFFSET $offset";
            
            return $this->db->query($sql, [$userId]);
            
        } catch (Exception $e) {
            error_log("Error getting hidden posts: " . $e->getMessage());
            return [];
        }
    }
    
    // Đếm số bài viết bị ẩn của user
    public function countHiddenPostsByUser($userId) {
        try {
            $sql = "SELECT COUNT(*) as count FROM hidden_posts hp
                    JOIN posts p ON hp.post_id = p.id
                    WHERE hp.user_id = ? AND p.status = 'published'";
            
            $result = $this->db->query($sql, [$userId]);
            return $result[0]['count'] ?? 0;
            
        } catch (Exception $e) {
            error_log("Error counting hidden posts: " . $e->getMessage());
            return 0;
        }
    }
    
    // Lọc bài viết bị ẩn khỏi danh sách
    public function filterHiddenPosts($posts, $userId) {
        if (empty($posts) || !$userId) {
            return $posts;
        }
        
        $postIds = array_column($posts, 'id');
        if (empty($postIds)) {
            return $posts;
        }
        
        try {
            $placeholders = str_repeat('?,', count($postIds) - 1) . '?';
            $sql = "SELECT post_id FROM hidden_posts WHERE user_id = ? AND post_id IN ($placeholders)";
            
            $params = array_merge([$userId], $postIds);
            $result = $this->db->query($sql, $params);
            
            $hiddenPostIds = array_column($result, 'post_id');
            
            // Lọc ra các bài viết không bị ẩn
            return array_filter($posts, function($post) use ($hiddenPostIds) {
                return !in_array($post['id'], $hiddenPostIds);
            });
            
        } catch (Exception $e) {
            error_log("Error filtering hidden posts: " . $e->getMessage());
            return $posts;
        }
    }
}
?>
