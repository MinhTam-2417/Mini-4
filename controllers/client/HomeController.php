<?php

namespace client;
require_once '../core/Controller.php';
require_once '../models/Post.php';

class HomeController extends \Controller{
    private $postModel;

    public function __construct() {
        $this->postModel = new \Post();
    }

    // hiển thị trang chủ bài viết 
    public function index() {
        $posts = $this->postModel->all();
        $this->view('client/home', ['posts' => $posts]);
    }

}
?>