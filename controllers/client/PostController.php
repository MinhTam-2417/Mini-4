<?php

namespace client;
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../models/Post.php';
require_once __DIR__ . '/../../models/Category.php';
require_once __DIR__ . '/../../models/Comment.php';

class PostController extends \Controller {
    private $postModel;
    private $categoryModel;
    private $commentModel;

    public function __construct() {
        $this->postModel = new \Post();
        $this->categoryModel = new \Category();
        $this->commentModel = new \Comment();
    }

    // Hiển thị trang tạo bài viết - CHỈ ADMIN MỚI ĐƯỢC TRUY CẬP
    public function create() {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            $_SESSION['error'] = 'Bạn không có quyền truy cập trang này. Chỉ admin mới được tạo bài viết.';
            header('Location: /Mini-4/public/');
            exit;
        }

        $categories = $this->categoryModel->getAll();
        $this->view('client/post/create', [
            'categories' => $categories
        ]);
    }

    // Lưu bài viết mới - CHỈ ADMIN MỚI ĐƯỢC TRUY CẬP
    public function store() {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            $_SESSION['error'] = 'Bạn không có quyền thực hiện hành động này. Chỉ admin mới được tạo bài viết.';
            header('Location: /Mini-4/public/');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Mini-4/public/post/create');
            exit;
        }

        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $excerpt = $_POST['excerpt'] ?? '';
        $categoryId = $_POST['category_id'] ?? '';
        $action = $_POST['action'] ?? 'draft';
        $status = ($action === 'publish') ? 'published' : 'draft';
        $imageFit = $_POST['image_fit'] ?? 'contain';

        // Validation
        if (empty($title) || empty($content)) {
            $_SESSION['error'] = 'Vui lòng nhập tiêu đề và nội dung bài viết';
            header('Location: /Mini-4/public/post/create');
            exit;
        }

        // Tạo slug từ title
        $slug = $this->createSlug($title);

        // Tạo excerpt nếu không có
        if (empty($excerpt)) {
            $excerpt = substr(strip_tags($content), 0, 200) . '...';
        }

        // Xử lý upload hình ảnh
        $featuredImage = null;
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/images/';
            $fileExtension = strtolower(pathinfo($_FILES['featured_image']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if (in_array($fileExtension, $allowedExtensions)) {
                $fileName = uniqid() . '_' . time() . '.' . $fileExtension;
                $uploadPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $uploadPath)) {
                    $featuredImage = 'uploads/images/' . $fileName;
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra khi upload hình ảnh';
                    header('Location: /Mini-4/public/post/create');
                    exit;
                }
            } else {
                $_SESSION['error'] = 'Chỉ chấp nhận file hình ảnh (JPG, PNG, GIF, WebP)';
                header('Location: /Mini-4/public/post/create');
                exit;
            }
        }

        $postData = [
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'excerpt' => $excerpt,
            'featured_image' => $featuredImage,
            'image_fit' => $imageFit,
            'category_id' => $categoryId ?: null,
            'user_id' => $_SESSION['user_id'],
            'status' => $status
        ];

        $postId = $this->postModel->create($postData);

        if ($postId) {
            $_SESSION['success'] = 'Bài viết đã được tạo thành công!';
            header('Location: /Mini-4/public/post/' . $postId);
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi tạo bài viết';
            header('Location: /Mini-4/public/post/create');
        }
        exit;
    }

    // Hiển thị chi tiết bài viết
    public function show($id) {
        $post = $this->postModel->findWithDetails($id);
        if (!$post) {
            http_response_code(404);
            echo "Bài viết không tồn tại";
            return;
        }

        // Tăng lượt xem
        $this->postModel->incrementViews($id);

        // Lấy comments
        $comments = $this->commentModel->getByPostId($id);
        
        // Lấy bài viết liên quan
        $relatedPosts = $this->postModel->getRelatedPosts($post['category_id'], $id);

        $this->view('client/post_detail', [
            'post' => $post,
            'comments' => $comments,
            'relatedPosts' => $relatedPosts
        ]);
    }

    // Thêm comment
    public function comment($postId) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /Mini-4/public/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Mini-4/public/post/' . $postId);
            exit;
        }

        $content = $_POST['content'] ?? '';
        if (empty($content)) {
            $_SESSION['error'] = 'Vui lòng nhập nội dung bình luận';
            header('Location: /Mini-4/public/post/' . $postId);
            exit;
        }

        $commentData = [
            'content' => $content,
            'user_id' => $_SESSION['user_id'],
            'post_id' => $postId,
            'status' => 'approved'
        ];

        $commentId = $this->commentModel->create($commentData);
        
        if ($commentId) {
            header('Location: /Mini-4/public/post/' . $postId);
            exit;
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi gửi bình luận';
            header('Location: /Mini-4/public/post/' . $postId);
            exit;
        }
    }

    // Tạo slug từ title
    private function createSlug($title) {
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        
        // Thêm timestamp để đảm bảo unique
        $slug .= '-' . time();
        
        return $slug;
    }
}
?>
