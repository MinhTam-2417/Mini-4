<?php

namespace client;
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../models/Post.php';
require_once __DIR__ . '/../../models/Category.php';

class SearchController extends \Controller {
    private $postModel;
    private $categoryModel;

    public function __construct() {
        $this->postModel = new \Post();
        $this->categoryModel = new \Category();
    }

    // Hiển thị trang tìm kiếm
    public function index() {
        $keyword = $_GET['q'] ?? '';
        $category = $_GET['category'] ?? '';
        $posts = [];
        $categories = $this->categoryModel->getAll();

        if (!empty($keyword)) {
            $posts = $this->postModel->search($keyword, $category);
        }

        $this->view('client/search', [
            'posts' => $posts,
            'categories' => $categories,
            'keyword' => $keyword,
            'selectedCategory' => $category,
            'current_page' => 'search',
            'page_title' => 'Tìm kiếm'
        ]);
    }
}
?> 