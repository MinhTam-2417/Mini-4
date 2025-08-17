<?php

namespace client;

require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../models/HiddenPost.php';

class HidePostController extends \Controller {
    private $hiddenPostModel;
    
    public function __construct() {
        $this->hiddenPostModel = new \HiddenPost();
    }
    
    // Ẩn bài viết
    public function hidePost() {
        if (!isset($_SESSION['user_id'])) {
            $this->jsonResponse(['success' => false, 'message' => 'Bạn cần đăng nhập để ẩn bài viết']);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        
        $postId = $_POST['post_id'] ?? null;
        $userId = $_SESSION['user_id'];
        
        if (!$postId) {
            $this->jsonResponse(['success' => false, 'message' => 'Thiếu ID bài viết']);
            return;
        }
        
        $result = $this->hiddenPostModel->hidePost($userId, $postId);
        
        if ($result) {
            $this->jsonResponse([
                'success' => true, 
                'message' => 'Đã ẩn bài viết',
                'hidden' => true
            ]);
        } else {
            $this->jsonResponse([
                'success' => false, 
                'message' => 'Bài viết đã được ẩn trước đó'
            ]);
        }
    }
    
    // Hiện bài viết
    public function unhidePost() {
        if (!isset($_SESSION['user_id'])) {
            $this->jsonResponse(['success' => false, 'message' => 'Bạn cần đăng nhập để hiện bài viết']);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        
        $postId = $_POST['post_id'] ?? null;
        $userId = $_SESSION['user_id'];
        
        if (!$postId) {
            $this->jsonResponse(['success' => false, 'message' => 'Thiếu ID bài viết']);
            return;
        }
        
        $result = $this->hiddenPostModel->unhidePost($userId, $postId);
        
        if ($result) {
            $this->jsonResponse([
                'success' => true, 
                'message' => 'Đã hiện bài viết',
                'hidden' => false
            ]);
        } else {
            $this->jsonResponse([
                'success' => false, 
                'message' => 'Không thể hiện bài viết'
            ]);
        }
    }
    
    // Toggle ẩn/hiện bài viết
    public function toggleHide() {
        if (!isset($_SESSION['user_id'])) {
            $this->jsonResponse(['success' => false, 'message' => 'Bạn cần đăng nhập']);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        
        $postId = $_POST['post_id'] ?? null;
        $userId = $_SESSION['user_id'];
        
        if (!$postId) {
            $this->jsonResponse(['success' => false, 'message' => 'Thiếu ID bài viết']);
            return;
        }
        
        $isHidden = $this->hiddenPostModel->isHidden($userId, $postId);
        
        if ($isHidden) {
            // Hiện bài viết
            $result = $this->hiddenPostModel->unhidePost($userId, $postId);
            $message = 'Đã hiện bài viết';
            $hidden = false;
        } else {
            // Ẩn bài viết
            $result = $this->hiddenPostModel->hidePost($userId, $postId);
            $message = 'Đã ẩn bài viết';
            $hidden = true;
        }
        
        if ($result) {
            $this->jsonResponse([
                'success' => true,
                'message' => $message,
                'hidden' => $hidden
            ]);
        } else {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Có lỗi xảy ra'
            ]);
        }
    }
    
    // Trang bài viết đã ẩn
    public function hiddenPosts() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Bạn cần đăng nhập để xem bài viết đã ẩn';
            header('Location: /Mini-4/public/login');
            exit;
        }
        
        $userId = $_SESSION['user_id'];
        $page = $_GET['page'] ?? 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $hiddenPosts = $this->hiddenPostModel->getHiddenPostsByUser($userId, $limit, $offset);
        $totalCount = $this->hiddenPostModel->countHiddenPostsByUser($userId);
        $totalPages = ceil($totalCount / $limit);
        
        // Thêm user_hidden = true cho tất cả bài viết
        foreach ($hiddenPosts as &$post) {
            $post['user_hidden'] = true;
        }
        
        $this->view('client/hidden_posts', [
            'hidden_posts' => $hiddenPosts,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_count' => $totalCount,
            'page_title' => 'Bài viết đã ẩn',
            'current_page_name' => 'hidden_posts'
        ]);
    }
    
    // Lấy trạng thái ẩn của bài viết
    public function getHideStatus() {
        if (!isset($_SESSION['user_id'])) {
            $this->jsonResponse(['success' => false, 'message' => 'Bạn cần đăng nhập']);
            return;
        }
        
        $postId = $_GET['post_id'] ?? null;
        $userId = $_SESSION['user_id'];
        
        if (!$postId) {
            $this->jsonResponse(['success' => false, 'message' => 'Thiếu ID bài viết']);
            return;
        }
        
        $isHidden = $this->hiddenPostModel->isHidden($userId, $postId);
        
        $this->jsonResponse([
            'success' => true,
            'hidden' => $isHidden
        ]);
    }
    
    private function jsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
?>


