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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            
            // Validation
            if (empty($name)) {
                $_SESSION['error'] = 'Tên danh mục không được để trống!';
                header('Location: /Mini-4/public/admin/categories/create');
                exit;
            }
            
            // Tạo slug từ tên
            $slug = $this->createSlug($name);
            
            $data = [
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            if ($this->categoryModel->create($data)) {
                $_SESSION['success'] = 'Đã tạo danh mục thành công!';
                header('Location: /Mini-4/public/admin/categories');
            } else {
                $_SESSION['error'] = 'Không thể tạo danh mục. Vui lòng thử lại!';
                header('Location: /Mini-4/public/admin/categories/create');
            }
            exit;
        }
        
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            
            // Validation
            if (empty($name)) {
                $_SESSION['error'] = 'Tên danh mục không được để trống!';
                header('Location: /Mini-4/public/admin/categories/' . $id . '/edit');
                exit;
            }
            
            // Tạo slug từ tên
            $slug = $this->createSlug($name);
            
            $data = [
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            if ($this->categoryModel->update($id, $data)) {
                $_SESSION['success'] = 'Đã cập nhật danh mục thành công!';
                header('Location: /Mini-4/public/admin/categories');
            } else {
                $_SESSION['error'] = 'Không thể cập nhật danh mục. Vui lòng thử lại!';
                header('Location: /Mini-4/public/admin/categories/' . $id . '/edit');
            }
            exit;
        }
        
        header('Location: /Mini-4/public/admin/categories');
        exit;
    }

    // Tạo slug từ tên
    private function createSlug($string) {
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9\s-]/', '', $string);
        $string = preg_replace('/[\s-]+/', '-', $string);
        $string = trim($string, '-');
        return $string;
    }

    // Xóa danh mục
    public function delete($id) {
        if ($this->categoryModel->delete($id)) {
            $_SESSION['success'] = 'Đã xóa danh mục thành công!';
        } else {
            $_SESSION['error'] = 'Không thể xóa danh mục. Vui lòng thử lại!';
        }
        header('Location: /Mini-4/public/admin/categories');
        exit;
    }
}
