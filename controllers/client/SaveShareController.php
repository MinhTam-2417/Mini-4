<?php

namespace client;

require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../models/SavedPost.php';
require_once __DIR__ . '/../../models/SharedPost.php';

class SaveShareController extends \Controller {
    private $savedPostModel;
    private $sharedPostModel;
    
    public function __construct() {
        $this->savedPostModel = new \SavedPost();
        $this->sharedPostModel = new \SharedPost();
    }
    
    // Lưu bài viết
    public function savePost() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Bạn cần đăng nhập để lưu bài viết']);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        
        $postId = $_POST['post_id'] ?? null;
        $userId = $_SESSION['user_id'];
        
        if (!$postId) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Thiếu ID bài viết']);
            return;
        }
        
        $result = $this->savedPostModel->savePost($userId, $postId);
        
        if ($result) {
            $saveCount = $this->savedPostModel->getSaveCount($postId);
            echo json_encode([
                'success' => true, 
                'message' => 'Đã lưu bài viết',
                'saved' => true,
                'save_count' => $saveCount
            ]);
        } else {
            echo json_encode([
                'success' => false, 
                'message' => 'Bài viết đã được lưu trước đó'
            ]);
        }
    }
    
    // Bỏ lưu bài viết
    public function unsavePost() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Bạn cần đăng nhập để bỏ lưu bài viết']);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        
        $postId = $_POST['post_id'] ?? null;
        $userId = $_SESSION['user_id'];
        
        if (!$postId) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Thiếu ID bài viết']);
            return;
        }
        
        $result = $this->savedPostModel->unsavePost($userId, $postId);
        
        if ($result) {
            $saveCount = $this->savedPostModel->getSaveCount($postId);
            echo json_encode([
                'success' => true, 
                'message' => 'Đã bỏ lưu bài viết',
                'saved' => false,
                'save_count' => $saveCount
            ]);
        } else {
            echo json_encode([
                'success' => false, 
                'message' => 'Không thể bỏ lưu bài viết'
            ]);
        }
    }
    
    // Chia sẻ bài viết
    public function sharePost() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Bạn cần đăng nhập để chia sẻ bài viết']);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        
        $postId = $_POST['post_id'] ?? null;
        $shareType = $_POST['share_type'] ?? null;
        $userId = $_SESSION['user_id'];
        
        if (!$postId || !$shareType) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Thiếu thông tin chia sẻ']);
            return;
        }
        
        // Validate share type
        $validTypes = ['facebook', 'twitter', 'linkedin', 'email', 'copy_link'];
        if (!in_array($shareType, $validTypes)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Loại chia sẻ không hợp lệ']);
            return;
        }
        
        $result = $this->sharedPostModel->recordShare($userId, $postId, $shareType);
        
        if ($result) {
            $shareCount = $this->sharedPostModel->getShareCount($postId);
            echo json_encode([
                'success' => true, 
                'message' => 'Đã ghi lại lượt chia sẻ',
                'share_count' => $shareCount
            ]);
        } else {
            echo json_encode([
                'success' => false, 
                'message' => 'Không thể ghi lại lượt chia sẻ'
            ]);
        }
    }
    
    // Lấy trạng thái lưu của bài viết
    public function getSaveStatus() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Bạn cần đăng nhập']);
            return;
        }
        
        $postId = $_GET['post_id'] ?? null;
        $userId = $_SESSION['user_id'];
        
        if (!$postId) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Thiếu ID bài viết']);
            return;
        }
        
        $isSaved = $this->savedPostModel->isSaved($userId, $postId);
        $saveCount = $this->savedPostModel->getSaveCount($postId);
        $shareCount = $this->sharedPostModel->getShareCount($postId);
        
        echo json_encode([
            'success' => true,
            'saved' => $isSaved,
            'save_count' => $saveCount,
            'share_count' => $shareCount
        ]);
    }
    
    // Trang bài viết đã lưu
    public function savedPosts() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Bạn cần đăng nhập để xem bài viết đã lưu';
            header('Location: /Mini-4/public/login');
            exit;
        }
        
        $userId = $_SESSION['user_id'];
        $page = $_GET['page'] ?? 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $savedPosts = $this->savedPostModel->getSavedPostsByUser($userId, $limit, $offset);
        $totalCount = $this->savedPostModel->countSavedPostsByUser($userId);
        $totalPages = ceil($totalCount / $limit);
        
        $this->view('client/saved_posts', [
            'saved_posts' => $savedPosts,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_count' => $totalCount,
            'page_title' => 'Bài viết đã lưu',
            'current_page_name' => 'saved_posts'
        ]);
    }
    
    // Trang lịch sử chia sẻ
    public function shareHistory() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Bạn cần đăng nhập để xem lịch sử chia sẻ';
            header('Location: /Mini-4/public/login');
            exit;
        }
        
        $userId = $_SESSION['user_id'];
        $page = $_GET['page'] ?? 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $shareHistory = $this->sharedPostModel->getShareHistoryByUser($userId, $limit, $offset);
        
        $this->view('client/share_history', [
            'share_history' => $shareHistory,
            'current_page' => $page,
            'page_title' => 'Lịch sử chia sẻ'
        ]);
    }
}
