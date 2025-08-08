<?php

namespace admin;
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../models/Category.php';

class CategoryController extends \Controller {
    private $categoryModel;

    public function __construct() {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: /Mini-4/public/login');
            exit;
        }

        $this->categoryModel = new \Category();
    }

    // Hiển thị danh sách danh mục
    public function index() {
        $categories = $this->categoryModel->getAll();
        $this->view('admin/categories/index', ['categories' => $categories]);
    }

    // Hiển thị form tạo danh mục
    public function create() {
        $this->view('admin/categories/create');
    }

    // Lưu danh mục mới
    public function store() {
        // Implementation sẽ thêm sau
        header('Location: /Mini-4/public/admin/categories');
        exit;
    }

    // Hiển thị form sửa danh mục
    public function edit($id) {
        $category = $this->categoryModel->findById($id);
        $this->view('admin/categories/edit', ['category' => $category]);
    }

    // Cập nhật danh mục
    public function update($id) {
        // Implementation sẽ thêm sau
        header('Location: /Mini-4/public/admin/categories');
        exit;
    }

    // Xóa danh mục
    public function delete($id) {
        // Implementation sẽ thêm sau
        header('Location: /Mini-4/public/admin/categories');
        exit;
    }
}
