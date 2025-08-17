<?php
namespace admin;

require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../models/Like.php';
require_once __DIR__ . '/../../models/Post.php';
require_once __DIR__ . '/../../models/User.php';

class LikeController extends \Controller {
    private $likeModel;
    private $postModel;
    private $userModel;

    public function __construct() {
        $this->likeModel = new \Like();
        $this->postModel = new \Post();
        $this->userModel = new \User();
    }

    // Hiển thị danh sách tất cả lượt like
    public function index() {
        $this->isAuthenticated('admin');
        
        // Lấy danh sách likes với thông tin chi tiết
        $likes = $this->likeModel->getAllLikesWithDetails();
        
        $this->view('admin/likes/index', [
            'likes' => $likes,
            'title' => 'Quản lý lượt like'
        ]);
    }

    // Xóa like
    public function delete($id) {
        $this->isAuthenticated('admin');
        
        $result = $this->likeModel->deleteById($id);
        
        if ($result) {
            $_SESSION['success'] = 'Đã xóa lượt like thành công';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi xóa lượt like';
        }
        
        $this->redirect('/Mini-4/public/admin/likes');
    }

    // Xem chi tiết like theo bài viết
    public function byPost($postId) {
        $this->isAuthenticated('admin');
        
        $post = $this->postModel->findById($postId);
        $likes = $this->likeModel->getUsersWhoLiked($postId);
        
        $this->view('admin/likes/by_post', [
            'post' => $post,
            'likes' => $likes,
            'title' => 'Lượt like bài viết: ' . $post['title']
        ]);
    }

    // Xem chi tiết like theo user
    public function byUser($userId) {
        $this->isAuthenticated('admin');
        
        $user = $this->userModel->findById($userId);
        $likes = $this->likeModel->getPostsLikedByUser($userId);
        
        $this->view('admin/likes/by_user', [
            'user' => $user,
            'likes' => $likes,
            'title' => 'Bài viết đã like bởi: ' . $user['username']
        ]);
    }

    // Thống kê likes
    public function stats() {
        $this->isAuthenticated('admin');
        
        $stats = $this->likeModel->getStats();
        
        $this->view('admin/likes/stats', [
            'stats' => $stats,
            'title' => 'Thống kê lượt like'
        ]);
    }
}
?>

