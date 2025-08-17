<?php

namespace client;
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../models/Post.php';
require_once __DIR__ . '/../../models/HiddenPost.php';

class HomeController extends \Controller{
    private $postModel;
    private $hiddenPostModel;

    public function __construct() {
        $this->postModel = new \Post();
        $this->hiddenPostModel = new \HiddenPost();
    }

    // hiển thị trang chủ bài viết 
    public function index() {
        $userId = $_SESSION['user_id'] ?? null;
        $posts = $this->postModel->getAllPublishedWithStats($userId);
        
        // Lọc bài viết bị ẩn nếu user đã đăng nhập
        if ($userId) {
            $posts = $this->hiddenPostModel->filterHiddenPosts($posts, $userId);
        }
        
        $this->view('client/home', [
            'posts' => $posts,
            'current_page' => 'home',
            'page_title' => 'Trang chủ'
        ]);
    }

}
?>