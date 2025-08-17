<?php

require_once __DIR__ . '/../core/Model.php';

class Tag extends Model
{
    protected $table = 'tags';
    
    public function __construct()
    {
        parent::__construct($this->table);
    }
    
    /**
     * Tạo slug từ tên tag
     */
    public function createSlug($name)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        
        // Kiểm tra slug đã tồn tại chưa
        $existingSlug = $slug;
        $counter = 1;
        
        while ($this->findBySlug($existingSlug)) {
            $existingSlug = $slug . '-' . $counter;
            $counter++;
        }
        
        return $existingSlug;
    }
    
    /**
     * Tìm tag theo slug
     */
    public function findBySlug($slug)
    {
        $sql = "SELECT * FROM {$this->table} WHERE slug = ?";
        $result = $this->db->query($sql, [$slug]);
        return $result ? $result[0] : null;
    }
    
    /**
     * Lấy tất cả tags với số lượng bài viết
     */
    public function getAllWithPostCount()
    {
        $sql = "SELECT t.*, COUNT(pt.post_id) as post_count 
                FROM {$this->table} t 
                LEFT JOIN post_tags pt ON t.id = pt.tag_id 
                GROUP BY t.id 
                ORDER BY t.name ASC";
        return $this->db->query($sql);
    }
    
    /**
     * Lấy tags theo bài viết
     */
    public function getTagsByPost($postId)
    {
        $sql = "SELECT t.* FROM {$this->table} t 
                INNER JOIN post_tags pt ON t.id = pt.tag_id 
                WHERE pt.post_id = ? 
                ORDER BY t.name ASC";
        return $this->db->query($sql, [$postId]);
    }
    
    /**
     * Thêm tags cho bài viết
     */
    public function addTagsToPost($postId, $tagIds)
    {
        // Xóa tags cũ
        $this->removeTagsFromPost($postId);
        
        // Thêm tags mới
        if (!empty($tagIds)) {
            $sql = "INSERT INTO post_tags (post_id, tag_id) VALUES (?, ?)";
            
            foreach ($tagIds as $tagId) {
                $this->db->execute($sql, [$postId, $tagId]);
            }
        }
    }
    
    /**
     * Xóa tags khỏi bài viết
     */
    public function removeTagsFromPost($postId)
    {
        $sql = "DELETE FROM post_tags WHERE post_id = ?";
        return $this->db->execute($sql, [$postId]);
    }
    
    /**
     * Tìm kiếm tags
     */
    public function search($keyword)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE name LIKE ? OR description LIKE ? 
                ORDER BY name ASC";
        $keyword = "%{$keyword}%";
        return $this->db->query($sql, [$keyword, $keyword]);
    }
    
    /**
     * Lấy tags phổ biến (có nhiều bài viết nhất)
     */
    public function getPopularTags($limit = 10)
    {
        $sql = "SELECT t.*, COUNT(pt.post_id) as post_count 
                FROM {$this->table} t 
                INNER JOIN post_tags pt ON t.id = pt.tag_id 
                GROUP BY t.id 
                ORDER BY post_count DESC 
                LIMIT ?";
        return $this->db->query($sql, [$limit]);
    }
    
    /**
     * Tìm tag theo tên
     */
    public function findByName($name)
    {
        $sql = "SELECT * FROM {$this->table} WHERE name = ?";
        $result = $this->db->query($sql, [$name]);
        return $result ? $result[0] : null;
    }
    
    /**
     * Lấy bài viết theo tag
     */
    public function getPostsByTag($tagId)
    {
        $sql = "SELECT p.* FROM posts p 
                INNER JOIN post_tags pt ON p.id = pt.post_id 
                WHERE pt.tag_id = ? 
                ORDER BY p.created_at DESC";
        return $this->db->query($sql, [$tagId]);
    }
    
    /**
     * Lấy tất cả tags
     */
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY name ASC";
        return $this->db->query($sql);
    }
    
    /**
     * Lấy tổng số tags
     */
    public function getTotalTags()
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $result = $this->db->query($sql);
        return $result ? $result[0]['total'] : 0;
    }
    
    /**
     * Tìm tag theo ID
     */
    public function findById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $result = $this->db->query($sql, [$id]);
        return $result ? $result[0] : null;
    }
    
    /**
     * Xóa tag
     */
    public function delete($id)
    {
        // Xóa các liên kết trong bảng post_tags trước
        $sql = "DELETE FROM post_tags WHERE tag_id = ?";
        $this->db->execute($sql, [$id]);
        
        // Sau đó xóa tag
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }
    
    /**
     * Cập nhật tag
     */
    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} SET name = ?, slug = ?, description = ?, updated_at = ? WHERE id = ?";
        return $this->db->execute($sql, [
            $data['name'],
            $data['slug'],
            $data['description'] ?? null,
            date('Y-m-d H:i:s'),
            $id
        ]);
    }
    
    /**
     * Tạo tag mới
     */
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (name, slug, description, color, created_at) VALUES (?, ?, ?, ?, ?)";
        return $this->db->execute($sql, [
            $data['name'],
            $data['slug'],
            $data['description'] ?? null,
            $data['color'] ?? '#007bff',
            date('Y-m-d H:i:s')
        ]);
    }
}
