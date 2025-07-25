<?php 

//Điểm vào chính của ứng dụng
require_once '../core/Router.php';
require_once '../config/database.php';

//khởi tạo router
$router = new Router();

//định nghĩa các router cho client (khách hàng)
$router->addRoute('GET', '/', 'client/HomeController@index');
$router->addRoute('GET', '/post/(\d+)', 'client/PostController@show');
$router->addRoute('POST', '/post/(\d+)/comment', 'client/PostController@comment');
$router->addRoute('GET', '/login', 'client/AuthController@login');
$router->addRoute('POST', '/login', 'client/AuthController@doLogin');
$router->addRoute('GET', '/register', 'client/AuthController@register');
$router->addRoute('POST', '/register', 'client/AuthController@doRegister');

//Định nghĩa các route cho admin
$router->addRoute('GET', '/admin', 'admin\DashboardController@index');
$router->addRoute('GET', '/admin/posts', 'admin\PostCotroller@index');
$router->addRoute('GET', '/admin/posts/create', 'admin\PostController@create');
$router->addRoute('POST', '/admin/posts', 'admin\PostController@store');
$router->addRoute('GET', '/admin/posts/(\d+)/edit', 'admin\PostController@edit');
$router->addRoute('POST', '/admin/posts/(\d+)', 'admin\PostController@update');
$router->addRoute('POST', '/admin/posts/(\d+)/delete', 'admin\PostController@delete');
$router->addRoute('GET', '/admin/categories', 'admin\CategoryController@index');
$router->addRoute('GET', '/admin/comments', 'admin\CommentController@index');
$router->addRoute('GET', '/admin/users', 'admin\UserController@index');

// Xử lý yêu cầu
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);