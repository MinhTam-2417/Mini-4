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
        // Implementation sẽ thêm sau
        header('Location: /Mini-4/public/admin/posts');
        exit;
    }

    // Hiển thị form sửa bài viết
    public function edit($id) {
        $post = $this->postModel->findById($id);
        $categories = $this->categoryModel->getAll();
        $this->view('admin/posts/edit', ['post' => $post, 'categories' => $categories]);
    }

    // Cập nhật bài viết
    public function update($id) {
        // Implementation sẽ thêm sau
        header('Location: /Mini-4/public/admin/posts');
        exit;
    }

    // Xóa bài viết
    public function delete($id) {
        // Implementation sẽ thêm sau
        header('Location: /Mini-4/public/admin/posts');
        exit;
    }
}
