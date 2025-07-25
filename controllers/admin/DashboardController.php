<?php

namespace admin;
require_once '../core/Controller.php';

class DashboardController extends \Controller {
    public function __construct() {
        $this->isAuthenticated('admin'); //chỉ admin truy cập đc
    }

    //hiển thị dashboard
    public function index() {
        $this->view('admin/dashboard');
    }
}