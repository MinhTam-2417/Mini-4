<?php
require_once __DIR__ . '/../core/Model.php';

class Comment extends Model {
    public function __construct(){
        parent::__construct('comments');
    }

    // Lấy comments theo post_id với thông tin user
    public function getByPostId($postId) {
        $sql = "SELECT c.*, u.username, u.full_name 
                FROM comments c 
                LEFT JOIN users u ON c.user_id = u.id 
                WHERE c.post_id = ? AND c.status = 'approved' 
                ORDER BY c.created_at ASC";
        return $this->db->query($sql, [$postId]);
    }

    // Lấy comments theo post_id (cho admin - bao gồm cả pending)
    public function getByPostIdForAdmin($postId) {
        $sql = "SELECT c.*, u.username, u.full_name 
                FROM comments c 
                LEFT JOIN users u ON c.user_id = u.id 
                WHERE c.post_id = ? 
                ORDER BY c.created_at DESC";
        return $this->db->query($sql, [$postId]);
    }

    // Duyệt comment
    public function approve($id) {
        return $this->update($id, ['status' => 'approved']);
    }

    // Từ chối comment
    public function reject($id) {
        return $this->update($id, ['status' => 'spam']);
    }

    // Đếm số comment của một bài viết
    public function countByPostId($postId) {
        $sql = "SELECT COUNT(*) as count FROM comments WHERE post_id = ? AND status = 'approved'";
        $result = $this->db->query($sql, [$postId]);
        return $result ? $result[0]['count'] : 0;
    }
}
?>
