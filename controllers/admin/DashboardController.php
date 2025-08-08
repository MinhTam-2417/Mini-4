<?php

namespace admin;
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../models/Post.php';
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/Comment.php';
require_once __DIR__ . '/../../models/Category.php';

class DashboardController extends \Controller {
    private $postModel;
    private $userModel;
    private $commentModel;
    private $categoryModel;

    public function __construct() {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: /Mini-4/public/login');
            exit;
        }

        $this->postModel = new \Post();
        $this->userModel = new \User();
        $this->commentModel = new \Comment();
        $this->categoryModel = new \Category();
    }

    // Hiển thị dashboard
    public function index() {
        // Lấy thống kê
        $totalPosts = $this->postModel->getTotalPosts();
        $totalUsers = $this->userModel->getTotalUsers();
        $totalComments = $this->commentModel->getTotalComments();
        $totalCategories = $this->categoryModel->getTotalCategories();
        
        // Lấy bài viết mới nhất
        $recentPosts = $this->postModel->getRecentPosts(5);
        
        // Lấy comments mới nhất
        $recentComments = $this->commentModel->getRecentComments(5);

        $this->view('admin/dashboard', [
            'totalPosts' => $totalPosts,
            'totalUsers' => $totalUsers,
            'totalComments' => $totalComments,
            'totalCategories' => $totalCategories,
            'recentPosts' => $recentPosts,
            'recentComments' => $recentComments
        ]);
    }
}