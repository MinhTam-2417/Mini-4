<?php
namespace client;

require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../models/Like.php';
require_once __DIR__ . '/../../models/Post.php';

class LikeController extends \Controller {
    private $likeModel;
    private $postModel;

    public function __construct() {
        $this->likeModel = new \Like();
        $this->postModel = new \Post();
    }

    // Hiển thị trang quản lý like của user
    public function myLikes() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        $userId = $_SESSION['user_id'];
        $likedPosts = $this->likeModel->getPostsLikedByUser($userId);
        
        // Thêm user_liked = true cho tất cả bài viết vì đây là trang bài viết đã thích
        foreach ($likedPosts as &$post) {
            $post['user_liked'] = true;
        }
        
        $this->view('client/my_likes', [
            'likedPosts' => $likedPosts,
            'title' => 'Bài viết đã thích',
            'current_page' => 'likes',
            'page_title' => 'Bài viết đã thích'
        ]);
    }

    // Toggle like/unlike
    public function toggle() {
        if (!isset($_SESSION['user_id'])) {
            $this->jsonResponse(['success' => false, 'message' => 'Vui lòng đăng nhập']);
            return;
        }

        $postId = $_POST['post_id'] ?? null;
        if (!$postId) {
            $this->jsonResponse(['success' => false, 'message' => 'Thiếu ID bài viết']);
            return;
        }

        $userId = $_SESSION['user_id'];
        
        try {
            $result = $this->likeModel->toggleLike($userId, $postId);
            $likeCount = $this->likeModel->getLikeCount($postId);
            $isLiked = $this->likeModel->hasUserLiked($userId, $postId);
            
            $this->jsonResponse([
                'success' => true,
                'liked' => $isLiked,
                'likeCount' => $likeCount,
                'message' => $isLiked ? 'Đã thích bài viết' : 'Đã bỏ thích bài viết'
            ]);
        } catch (Exception $e) {
            $this->jsonResponse(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // Like bài viết
    public function like() {
        if (!isset($_SESSION['user_id'])) {
            $this->jsonResponse(['success' => false, 'message' => 'Vui lòng đăng nhập']);
            return;
        }

        $postId = $_POST['post_id'] ?? null;
        if (!$postId) {
            $this->jsonResponse(['success' => false, 'message' => 'Thiếu ID bài viết']);
            return;
        }

        $userId = $_SESSION['user_id'];
        
        try {
            $this->likeModel->addLike($userId, $postId);
            $likeCount = $this->likeModel->getLikeCount($postId);
            
            $this->jsonResponse([
                'success' => true,
                'liked' => true,
                'likeCount' => $likeCount,
                'message' => 'Đã thích bài viết'
            ]);
        } catch (Exception $e) {
            $this->jsonResponse(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // Unlike bài viết
    public function unlike() {
        if (!isset($_SESSION['user_id'])) {
            $this->jsonResponse(['success' => false, 'message' => 'Vui lòng đăng nhập']);
            return;
        }

        $postId = $_POST['post_id'] ?? null;
        if (!$postId) {
            $this->jsonResponse(['success' => false, 'message' => 'Thiếu ID bài viết']);
            return;
        }

        $userId = $_SESSION['user_id'];
        
        try {
            $this->likeModel->removeLike($userId, $postId);
            $likeCount = $this->likeModel->getLikeCount($postId);
            
            $this->jsonResponse([
                'success' => true,
                'liked' => false,
                'likeCount' => $likeCount,
                'message' => 'Đã bỏ thích bài viết'
            ]);
        } catch (Exception $e) {
            $this->jsonResponse(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // Lấy số lượt like
    public function getLikeCount($postId) {
        try {
            $count = $this->likeModel->getLikeCount($postId);
            $this->jsonResponse(['success' => true, 'count' => $count]);
        } catch (Exception $e) {
            $this->jsonResponse(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // Lấy danh sách user đã like
    public function getUsersWhoLiked($postId) {
        try {
            $users = $this->likeModel->getUsersWhoLiked($postId);
            $this->jsonResponse(['success' => true, 'users' => $users]);
        } catch (Exception $e) {
            $this->jsonResponse(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    private function jsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
?>

