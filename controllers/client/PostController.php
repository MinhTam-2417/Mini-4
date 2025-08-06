<?php

namespace client;
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../models/Post.php';
require_once __DIR__ . '/../../models/Comment.php';

class PostController extends \Controller {
    private $postModel;
    private $commentModel;

    public function __construct() {
        $this->postModel = new \Post();
        $this->commentModel = new \Comment();
    }

    // Hiển thị chi tiết bài viết
    public function show($id) {
        // Tăng lượt xem
        $this->postModel->incrementViewCount($id);
        
        // Lấy thông tin bài viết
        $post = $this->postModel->findWithDetails($id);
        
        if (!$post) {
            http_response_code(404);
            echo "Bài viết không tồn tại";
            return;
        }

        // Lấy bài viết liên quan
        $relatedPosts = [];
        if ($post['category_id']) {
            $relatedPosts = $this->postModel->getRelatedPosts($post['category_id'], $id, 3);
        }

        // Lấy comments của bài viết
        $comments = $this->commentModel->getByPostId($id);

        $this->view('client/post_detail', [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
            'comments' => $comments
        ]);
    }

    // Xử lý thêm comment
    public function comment($postId) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo "Method not allowed";
            return;
        }

        // Kiểm tra đăng nhập (có thể thêm middleware sau)
        session_start();
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo "Vui lòng đăng nhập để bình luận";
            return;
        }

        $content = trim($_POST['content'] ?? '');
        if (empty($content)) {
            http_response_code(400);
            echo "Nội dung bình luận không được để trống";
            return;
        }

        $commentData = [
            'content' => $content,
            'user_id' => $_SESSION['user_id'],
            'post_id' => $postId,
            'status' => 'pending' // Có thể thay đổi thành 'approved' nếu không cần duyệt
        ];

        $commentId = $this->commentModel->create($commentData);
        
        if ($commentId) {
            // Redirect về trang chi tiết bài viết
            header("Location: /post/{$postId}");
            exit;
        } else {
            http_response_code(500);
            echo "Có lỗi xảy ra khi thêm bình luận";
        }
    }
}
?>
