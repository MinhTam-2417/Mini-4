<?php
require_once __DIR__ . '/../core/Model.php';

class Post extends Model {
    public function __construct(){
        parent::__construct('posts');
    }

    // Lấy tất cả bài viết đã publish với thông tin user và category
    public function getAllPublished() {
        $sql = "SELECT p.*, u.username as author_name, c.name as category_name 
                FROM posts p 
                LEFT JOIN users u ON p.user_id = u.id 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.status = 'published' 
                ORDER BY p.created_at DESC";
        return $this->db->query($sql);
    }

    // Lấy tất cả bài viết đã publish với thông tin like, save, share
    public function getAllPublishedWithStats($userId = null) {
        $sql = "SELECT p.*, u.username as author_name, c.name as category_name,
                       (SELECT COUNT(*) FROM likes WHERE post_id = p.id) as like_count,
                       (SELECT COUNT(*) FROM saved_posts WHERE post_id = p.id) as save_count,
                       (SELECT COUNT(*) FROM shared_posts WHERE post_id = p.id) as share_count";
        
        if ($userId) {
            $sql .= ", (SELECT COUNT(*) FROM likes WHERE post_id = p.id AND user_id = ?) as user_liked,
                       (SELECT COUNT(*) FROM saved_posts WHERE post_id = p.id AND user_id = ?) as user_saved";
            $sql .= " FROM posts p 
                      LEFT JOIN users u ON p.user_id = u.id 
                      LEFT JOIN categories c ON p.category_id = c.id 
                      WHERE p.status = 'published' 
                      ORDER BY p.created_at DESC";
            return $this->db->query($sql, [$userId, $userId]);
        } else {
            $sql .= " FROM posts p 
                      LEFT JOIN users u ON p.user_id = u.id 
                      LEFT JOIN categories c ON p.category_id = c.id 
                      WHERE p.status = 'published' 
                      ORDER BY p.created_at DESC";
            return $this->db->query($sql);
        }
    }

    // Lấy bài viết theo ID với thông tin user và category
    public function findWithDetails($id) {
        $sql = "SELECT p.*, u.username as author_name, u.full_name as author_full_name, 
                       c.name as category_name, c.slug as category_slug
                FROM posts p 
                LEFT JOIN users u ON p.user_id = u.id 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = ? AND p.status = 'published'";
        $result = $this->db->query($sql, [$id]);
        return $result ? $result[0] : null;
    }

    // Tăng lượt xem bài viết
    public function incrementViewCount($id) {
        $sql = "UPDATE posts SET view_count = view_count + 1 WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    // Lấy bài viết liên quan (cùng category)
    public function getRelatedPosts($categoryId, $currentPostId, $limit = 3) {
        $sql = "SELECT p.*, u.username as author_name 
                FROM posts p 
                LEFT JOIN users u ON p.user_id = u.id 
                WHERE p.category_id = ? AND p.id != ? AND p.status = 'published' 
                ORDER BY p.created_at DESC 
                LIMIT " . (int)$limit;
        return $this->db->query($sql, [$categoryId, $currentPostId]);
    }

    // Lấy bài viết theo category
    public function getByCategory($categoryId) {
        $sql = "SELECT p.*, u.username as author_name, c.name as category_name 
                FROM posts p 
                LEFT JOIN users u ON p.user_id = u.id 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.category_id = ? AND p.status = 'published' 
                ORDER BY p.created_at DESC";
        return $this->db->query($sql, [$categoryId]);
    }

    // Tìm kiếm bài viết
    public function search($keyword, $category = '') {
        $keyword = "%{$keyword}%";
        
        $sql = "SELECT p.*, u.username as author_name, c.name as category_name 
                FROM posts p 
                LEFT JOIN users u ON p.user_id = u.id 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE (p.title LIKE ? OR p.content LIKE ? OR p.excerpt LIKE ?) 
                AND p.status = 'published'";
        
        $params = [$keyword, $keyword, $keyword];
        
        if (!empty($category)) {
            $sql .= " AND p.category_id = ?";
            $params[] = $category;
        }
        
        $sql .= " ORDER BY p.created_at DESC";
        
        return $this->db->query($sql, $params);
    }

    // Lấy bài viết theo user
    public function getPostsByUser($userId) {
        $sql = "SELECT p.*, c.name as category_name 
                FROM posts p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.user_id = ? 
                ORDER BY p.created_at DESC";
        return $this->db->query($sql, [$userId]);
    }

    // Tạo bài viết mới
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (title, slug, content, excerpt, featured_image, image_fit, category_id, user_id, status, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $this->db->execute($sql, [
            $data['title'],
            $data['slug'],
            $data['content'],
            $data['excerpt'],
            $data['featured_image'],
            $data['image_fit'],
            $data['category_id'],
            $data['user_id'],
            $data['status']
        ]);
        
        return $this->db->lastInsertID();
    }

    // Tăng lượt xem
    public function incrementViews($id) {
        $sql = "UPDATE {$this->table} SET view_count = view_count + 1 WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    public function getTotalPosts() {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $result = $this->db->query($sql);
        return $result[0]['total'] ?? 0;
    }

    public function getRecentPosts($limit = 5) {
        $sql = "SELECT p.*, u.username as author_name, c.name as category_name 
                FROM {$this->table} p 
                LEFT JOIN users u ON p.user_id = u.id 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.created_at DESC 
                LIMIT " . (int)$limit;
        return $this->db->query($sql);
    }

    public function getAllPostsWithDetails() {
        $sql = "SELECT p.*, u.username as author_name, c.name as category_name 
                FROM {$this->table} p 
                LEFT JOIN users u ON p.user_id = u.id 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.created_at DESC";
        return $this->db->query($sql);
    }

    public function findById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $result = $this->db->query($sql, [$id]);
        return $result ? $result[0] : null;
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET 
                title = ?, 
                slug = ?, 
                content = ?, 
                excerpt = ?, 
                featured_image = ?, 
                image_fit = ?, 
                category_id = ?, 
                status = ?, 
                updated_at = NOW() 
                WHERE id = ?";
        
        return $this->db->execute($sql, [
            $data['title'],
            $data['slug'],
            $data['content'],
            $data['excerpt'],
            $data['featured_image'],
            $data['image_fit'],
            $data['category_id'],
            $data['status'],
            $id
        ]);
    }

    // Lấy bài viết với thông tin like
    public function findWithLikeInfo($id, $userId = null) {
        $sql = "SELECT p.*, u.username as author_name, u.full_name as author_full_name, 
                       c.name as category_name, c.slug as category_slug,
                       (SELECT COUNT(*) FROM likes WHERE post_id = p.id) as like_count";
        
        if ($userId) {
            $sql .= ", (SELECT COUNT(*) FROM likes WHERE post_id = p.id AND user_id = ?) as user_liked";
            $sql .= " FROM {$this->table} p 
                    LEFT JOIN users u ON p.user_id = u.id 
                    LEFT JOIN categories c ON p.category_id = c.id 
                    WHERE p.id = ? AND p.status = 'published'";
            $result = $this->db->query($sql, [$userId, $id]);
        } else {
            $sql .= ", 0 as user_liked";
            $sql .= " FROM {$this->table} p 
                    LEFT JOIN users u ON p.user_id = u.id 
                    LEFT JOIN categories c ON p.category_id = c.id 
                    WHERE p.id = ? AND p.status = 'published'";
            $result = $this->db->query($sql, [$id]);
        }
        
        if ($result) {
            $post = $result[0];
            $post['user_liked'] = $userId ? ($post['user_liked'] > 0) : false;
            return $post;
        }
        return null;
    }

    // Lấy tất cả bài viết với thông tin like
    public function getAllPublishedWithLikes($userId = null) {
        $sql = "SELECT p.*, u.username as author_name, c.name as category_name,
                       (SELECT COUNT(*) FROM likes WHERE post_id = p.id) as like_count";
        
        if ($userId) {
            $sql .= ", (SELECT COUNT(*) FROM likes WHERE post_id = p.id AND user_id = ?) as user_liked";
            $sql .= " FROM {$this->table} p 
                    LEFT JOIN users u ON p.user_id = u.id 
                    LEFT JOIN categories c ON p.category_id = c.id 
                    WHERE p.status = 'published'
                    ORDER BY p.created_at DESC";
            $posts = $this->db->query($sql, [$userId]);
        } else {
            $sql .= ", 0 as user_liked";
            $sql .= " FROM {$this->table} p 
                    LEFT JOIN users u ON p.user_id = u.id 
                    LEFT JOIN categories c ON p.category_id = c.id 
                    WHERE p.status = 'published'
                    ORDER BY p.created_at DESC";
            $posts = $this->db->query($sql);
        }
        
        if ($userId && $posts) {
            foreach ($posts as &$post) {
                $post['user_liked'] = $post['user_liked'] > 0;
            }
        }
        
        return $posts;
    }
    
    // Lấy bài viết với thông tin tags
    public function findWithTags($id) {
        $sql = "SELECT p.*, u.username as author_name, u.full_name as author_full_name, 
                       c.name as category_name, c.slug as category_slug
                FROM {$this->table} p 
                LEFT JOIN users u ON p.user_id = u.id 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = ? AND p.status = 'published'";
        $result = $this->db->query($sql, [$id]);
        
        if ($result) {
            $post = $result[0];
            // Lấy tags của bài viết
            $post['tags'] = $this->getTagsByPost($id);
            return $post;
        }
        return null;
    }
    
    // Lấy tags của bài viết
    public function getTagsByPost($postId) {
        $sql = "SELECT t.* FROM tags t 
                INNER JOIN post_tags pt ON t.id = pt.tag_id 
                WHERE pt.post_id = ? 
                ORDER BY t.name ASC";
        return $this->db->query($sql, [$postId]);
    }
    
    // Lấy bài viết theo tag
    public function getByTag($tagId) {
        $sql = "SELECT p.*, u.username as author_name, c.name as category_name 
                FROM {$this->table} p 
                INNER JOIN post_tags pt ON p.id = pt.post_id 
                LEFT JOIN users u ON p.user_id = u.id 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE pt.tag_id = ? AND p.status = 'published' 
                ORDER BY p.created_at DESC";
        return $this->db->query($sql, [$tagId]);
    }
    
    // Lấy bài viết với tags
    public function getAllPublishedWithTags($userId = null) {
        $posts = $this->getAllPublishedWithLikes($userId);
        
        if ($posts) {
            foreach ($posts as &$post) {
                $post['tags'] = $this->getTagsByPost($post['id']);
            }
        }
        
        return $posts;
    }
}
?>