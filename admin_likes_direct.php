<?php
// Direct access to admin likes (bypass URL rewriting)
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /Mini-4/public/login');
    exit;
}

// Include necessary files
require_once 'config/database.php';
require_once 'core/Controller.php';
require_once 'models/Like.php';
require_once 'models/Post.php';
require_once 'models/User.php';

// Create controller instance
$likeModel = new Like();
$postModel = new Post();
$userModel = new User();

// Handle actions
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

switch ($action) {
    case 'delete':
        if ($id && $_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($likeModel->deleteById($id)) {
                header('Location: admin_likes_direct.php?success=deleted');
            } else {
                header('Location: admin_likes_direct.php?error=delete_failed');
            }
            exit;
        }
        break;
        
    case 'stats':
        $stats = $likeModel->getStats();
        $view = 'admin/likes/stats';
        $data = ['stats' => $stats];
        break;
        
    case 'by_post':
        if ($id) {
            $post = $postModel->findById($id);
            $likes = $likeModel->getUsersWhoLiked($id);
            $view = 'admin/likes/by_post';
            $data = ['post' => $post, 'likes' => $likes];
        } else {
            header('Location: admin_likes_direct.php');
            exit;
        }
        break;
        
    case 'by_user':
        if ($id) {
            $user = $userModel->findById($id);
            $posts = $likeModel->getPostsLikedByUser($id);
            $view = 'admin/likes/by_user';
            $data = ['user' => $user, 'posts' => $posts];
        } else {
            header('Location: admin_likes_direct.php');
            exit;
        }
        break;
        
    default:
        $likes = $likeModel->getAllLikesWithDetails();
        $view = 'admin/likes/index';
        $data = ['likes' => $likes];
        break;
}

// Load view
extract($data);
require_once "views/{$view}.php";
?>







