<?php

namespace admin;
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../models/Post.php';
require_once __DIR__ . '/../../models/Category.php';

class PostController extends \Controller {
    private $postModel;
    private $categoryModel;

    public function __construct() {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: /Mini-4/public/login');
            exit;
        }

        $this->postModel = new \Post();
        $this->categoryModel = new \Category();
    }

    // Hiển thị danh sách bài viết
    public function index() {
        $posts = $this->postModel->getAllPostsWithDetails();
        $this->view('admin/posts/index', ['posts' => $posts]);
    }

    // Hiển thị form tạo bài viết
    public function create() {
        $categories = $this->categoryModel->getAll();
        $this->view('admin/posts/create', ['categories' => $categories]);
    }

    // Lưu bài viết mới
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Mini-4/public/admin/posts/create');
            exit;
        }

        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $excerpt = $_POST['excerpt'] ?? '';
        $categoryId = $_POST['category_id'] ?? '';
        $action = $_POST['action'] ?? 'draft';
        $status = ($action === 'publish') ? 'published' : 'draft';
        $imageFit = $_POST['image_fit'] ?? 'contain';

        // Validation
        if (empty($title) || empty($content)) {
            $_SESSION['error'] = 'Vui lòng nhập tiêu đề và nội dung bài viết';
            header('Location: /Mini-4/public/admin/posts/create');
            exit;
        }

        // Tạo slug từ title
        $slug = $this->createSlug($title);

        // Tạo excerpt nếu không có
        if (empty($excerpt)) {
            $excerpt = substr(strip_tags($content), 0, 200) . '...';
        }

        // Xử lý upload hình ảnh
        $featuredImage = null;
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/images/';
            $fileExtension = strtolower(pathinfo($_FILES['featured_image']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if (in_array($fileExtension, $allowedExtensions)) {
                $fileName = uniqid() . '_' . time() . '.' . $fileExtension;
                $uploadPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $uploadPath)) {
                    $featuredImage = 'uploads/images/' . $fileName;
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra khi upload hình ảnh';
                    header('Location: /Mini-4/public/admin/posts/create');
                    exit;
                }
            } else {
                $_SESSION['error'] = 'Chỉ chấp nhận file hình ảnh (JPG, PNG, GIF, WebP)';
                header('Location: /Mini-4/public/admin/posts/create');
                exit;
            }
        }

        $postData = [
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'excerpt' => $excerpt,
            'featured_image' => $featuredImage,
            'image_fit' => $imageFit,
            'category_id' => $categoryId ?: null,
            'user_id' => $_SESSION['user_id'],
            'status' => $status
        ];

        $postId = $this->postModel->create($postData);

        if ($postId) {
            $_SESSION['success'] = 'Bài viết đã được tạo thành công!';
            header('Location: /Mini-4/public/admin/posts');
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi tạo bài viết';
            header('Location: /Mini-4/public/admin/posts/create');
        }
        exit;
    }

    // Hiển thị form sửa bài viết
    public function edit($id) {
        $post = $this->postModel->findById($id);
        if (!$post) {
            $_SESSION['error'] = 'Không tìm thấy bài viết';
            header('Location: /Mini-4/public/admin/posts');
            exit;
        }
        
        $categories = $this->categoryModel->getAll();
        $this->view('admin/posts/edit', ['post' => $post, 'categories' => $categories]);
    }

    // Cập nhật bài viết
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Mini-4/public/admin/posts/' . $id . '/edit');
            exit;
        }

        $post = $this->postModel->findById($id);
        if (!$post) {
            $_SESSION['error'] = 'Không tìm thấy bài viết';
            header('Location: /Mini-4/public/admin/posts');
            exit;
        }

        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $excerpt = $_POST['excerpt'] ?? '';
        $categoryId = $_POST['category_id'] ?? '';
        $action = $_POST['action'] ?? 'draft';
        $status = ($action === 'publish') ? 'published' : 'draft';
        $imageFit = $_POST['image_fit'] ?? 'contain';

        // Validation
        if (empty($title) || empty($content)) {
            $_SESSION['error'] = 'Vui lòng nhập tiêu đề và nội dung bài viết';
            header('Location: /Mini-4/public/admin/posts/' . $id . '/edit');
            exit;
        }

        // Tạo slug từ title
        $slug = $this->createSlug($title);

        // Tạo excerpt nếu không có
        if (empty($excerpt)) {
            $excerpt = substr(strip_tags($content), 0, 200) . '...';
        }

        // Xử lý upload hình ảnh mới
        $featuredImage = $post['featured_image']; // Giữ lại hình cũ
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/images/';
            $fileExtension = strtolower(pathinfo($_FILES['featured_image']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if (in_array($fileExtension, $allowedExtensions)) {
                $fileName = uniqid() . '_' . time() . '.' . $fileExtension;
                $uploadPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $uploadPath)) {
                    // Xóa hình cũ nếu có
                    if ($post['featured_image'] && file_exists(__DIR__ . '/../../public/' . $post['featured_image'])) {
                        unlink(__DIR__ . '/../../public/' . $post['featured_image']);
                    }
                    $featuredImage = 'uploads/images/' . $fileName;
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra khi upload hình ảnh';
                    header('Location: /Mini-4/public/admin/posts/' . $id . '/edit');
                    exit;
                }
            } else {
                $_SESSION['error'] = 'Chỉ chấp nhận file hình ảnh (JPG, PNG, GIF, WebP)';
                header('Location: /Mini-4/public/admin/posts/' . $id . '/edit');
                exit;
            }
        }

        $postData = [
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'excerpt' => $excerpt,
            'featured_image' => $featuredImage,
            'image_fit' => $imageFit,
            'category_id' => $categoryId ?: null,
            'status' => $status
        ];

        if ($this->postModel->update($id, $postData)) {
            $_SESSION['success'] = 'Bài viết đã được cập nhật thành công!';
            header('Location: /Mini-4/public/admin/posts');
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi cập nhật bài viết';
            header('Location: /Mini-4/public/admin/posts/' . $id . '/edit');
        }
        exit;
    }

    // Xóa bài viết
    public function delete($id) {
        // Debug: Log the delete attempt
        error_log("Attempting to delete post ID: " . $id);
        
        $post = $this->postModel->findById($id);
        if (!$post) {
            error_log("Post not found with ID: " . $id);
            $_SESSION['error'] = 'Không tìm thấy bài viết';
            header('Location: /Mini-4/public/admin/posts');
            exit;
        }

        error_log("Found post: " . $post['title']);

        // Xóa hình ảnh nếu có
        if ($post['featured_image'] && file_exists(__DIR__ . '/../../public/' . $post['featured_image'])) {
            $deleted = unlink(__DIR__ . '/../../public/' . $post['featured_image']);
            error_log("Image deletion result: " . ($deleted ? "success" : "failed"));
        }

        // Xóa comments liên quan
        require_once __DIR__ . '/../../models/Comment.php';
        $commentModel = new \Comment();
        $comments = $commentModel->getByPostIdForAdmin($id);
        error_log("Found " . count($comments) . " comments to delete");
        
        foreach ($comments as $comment) {
            $commentDeleted = $commentModel->delete($comment['id']);
            error_log("Comment " . $comment['id'] . " deletion: " . ($commentDeleted ? "success" : "failed"));
        }

        $postDeleted = $this->postModel->delete($id);
        error_log("Post deletion result: " . ($postDeleted ? "success" : "failed"));
        
        if ($postDeleted) {
            $_SESSION['success'] = 'Bài viết đã được xóa thành công!';
            error_log("Success message set: " . $_SESSION['success']);
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi xóa bài viết';
            error_log("Error message set: " . $_SESSION['error']);
        }
        
        error_log("Redirecting to: /Mini-4/public/admin/posts");
        
        // Chỉ redirect nếu không phải là test
        if (!defined('TESTING')) {
            header('Location: /Mini-4/public/admin/posts');
            exit;
        }
    }

    // Tạo slug từ title
    private function createSlug($title) {
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }
}
