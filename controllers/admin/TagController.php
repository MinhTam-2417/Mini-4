<?php

namespace admin;
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../models/Tag.php';

class TagController extends \Controller
{
    private $tagModel;
    
    public function __construct()
    {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: /Mini-4/public/login');
            exit;
        }

        $this->tagModel = new \Tag();
    }
    
    /**
     * Hiển thị danh sách tags
     */
    public function index()
    {
        $search = $_GET['search'] ?? '';
        
        if (!empty($search)) {
            $tags = $this->tagModel->search($search);
        } else {
            $tags = $this->tagModel->getAllWithPostCount();
        }
        
        $this->view('admin/tags/index', [
            'tags' => $tags,
            'search' => $search
        ]);
    }
    
    /**
     * Hiển thị form tạo tag mới
     */
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $description = trim($_POST['description'] ?? '');
            $color = trim($_POST['color'] ?? '#007bff');
            
            // Validation
            if (empty($name)) {
                $_SESSION['error'] = 'Tên thẻ không được để trống!';
                $this->view('admin/tags/create', [
                    'name' => $name,
                    'description' => $description,
                    'color' => $color
                ]);
                return;
            }
            
            // Kiểm tra tên tag đã tồn tại
            $existingTag = $this->tagModel->findByName($name);
            if ($existingTag) {
                $_SESSION['error'] = 'Tên thẻ đã tồn tại!';
                $this->view('admin/tags/create', [
                    'name' => $name,
                    'description' => $description,
                    'color' => $color
                ]);
                return;
            }
            
            // Tạo slug
            $slug = $this->tagModel->createSlug($name);
            
            // Tạo tag
            $tagId = $this->tagModel->create([
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'color' => $color
            ]);
            
            if ($tagId) {
                $_SESSION['success'] = 'Tạo thẻ thành công!';
                header('Location: /Mini-4/public/admin/tags');
                exit;
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi tạo thẻ!';
                $this->view('admin/tags/create', [
                    'name' => $name,
                    'description' => $description,
                    'color' => $color
                ]);
            }
        } else {
            $this->view('admin/tags/create');
        }
    }
    
    /**
     * Hiển thị form chỉnh sửa tag
     */
    public function edit($id)
    {
        $tag = $this->tagModel->findById($id);
        
        if (!$tag) {
            $_SESSION['error'] = 'Không tìm thấy thẻ!';
            header('Location: /Mini-4/public/admin/tags');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $description = trim($_POST['description'] ?? '');
            $color = trim($_POST['color'] ?? '#007bff');
            
            // Validation
            if (empty($name)) {
                $_SESSION['error'] = 'Tên thẻ không được để trống!';
                $this->view('admin/tags/edit', [
                    'tag' => $tag,
                    'name' => $name,
                    'description' => $description,
                    'color' => $color
                ]);
                return;
            }
            
            // Kiểm tra tên tag đã tồn tại (trừ tag hiện tại)
            $existingTag = $this->tagModel->findByName($name);
            if ($existingTag && $existingTag['id'] != $id) {
                $_SESSION['error'] = 'Tên thẻ đã tồn tại!';
                $this->view('admin/tags/edit', [
                    'tag' => $tag,
                    'name' => $name,
                    'description' => $description,
                    'color' => $color
                ]);
                return;
            }
            
            // Tạo slug mới nếu tên thay đổi
            $slug = $tag['name'] !== $name ? $this->tagModel->createSlug($name) : $tag['slug'];
            
            // Cập nhật tag
            $result = $this->tagModel->update($id, [
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'color' => $color
            ]);
            
            if ($result) {
                $_SESSION['success'] = 'Cập nhật thẻ thành công!';
                header('Location: /Mini-4/public/admin/tags');
                exit;
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi cập nhật thẻ!';
                $this->view('admin/tags/edit', [
                    'tag' => $tag,
                    'name' => $name,
                    'description' => $description,
                    'color' => $color
                ]);
            }
        } else {
            $this->view('admin/tags/edit', [
                'tag' => $tag
            ]);
        }
    }
    
    /**
     * Xóa tag
     */
    public function delete($id)
    {
        $tag = $this->tagModel->findById($id);
        
        if (!$tag) {
            $_SESSION['error'] = 'Không tìm thấy thẻ!';
            header('Location: /admin/tags');
            exit;
        }
        
        // Kiểm tra xem tag có được sử dụng trong bài viết nào không
        $postsWithTag = $this->tagModel->getPostsByTag($id);
        if (!empty($postsWithTag)) {
            $_SESSION['error'] = 'Không thể xóa thẻ này vì đang được sử dụng trong ' . count($postsWithTag) . ' bài viết!';
            header('Location: /Mini-4/public/admin/tags');
            exit;
        }
        
        $result = $this->tagModel->delete($id);
        
        if ($result) {
            $_SESSION['success'] = 'Xóa thẻ thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi xóa thẻ!';
        }
        
        header('Location: /Mini-4/public/admin/tags');
        exit;
    }
    
    /**
     * API để lấy danh sách tags (cho AJAX)
     */
    public function apiGetTags()
    {
        header('Content-Type: application/json');
        
        $search = $_GET['q'] ?? '';
        
        if (!empty($search)) {
            $tags = $this->tagModel->search($search);
        } else {
            $tags = $this->tagModel->getAll();
        }
        
        echo json_encode($tags);
    }
}
