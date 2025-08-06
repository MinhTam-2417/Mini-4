<?php 
session_start();

//Điểm vào chính của ứng dụng
require_once '../core/Router.php';
require_once '../config/database.php';

//khởi tạo router
$router = new Router();

//định nghĩa các router cho client (khách hàng)
$router->addRouter('GET', '/', 'client/HomeController@index');
$router->addRouter('GET', '/post/(\d+)', 'client/PostController@show');
$router->addRouter('POST', '/post/(\d+)/comment', 'client/PostController@comment');
$router->addRouter('GET', '/login', 'client/AuthController@login');
$router->addRouter('POST', '/login', 'client/AuthController@doLogin');
$router->addRouter('GET', '/register', 'client/AuthController@register');
$router->addRouter('POST', '/register', 'client/AuthController@doRegister');
$router->addRouter('GET', '/logout', 'client/AuthController@logout');


//Định nghĩa các route cho admin
$router->addRouter('GET', '/admin', 'admin\DashboardController@index');
$router->addRouter('GET', '/admin/posts', 'admin\PostController@index');
$router->addRouter('GET', '/admin/posts/create', 'admin\PostController@create');
$router->addRouter('POST', '/admin/posts', 'admin\PostController@store');
$router->addRouter('GET', '/admin/posts/(\d+)/edit', 'admin\PostController@edit');
$router->addRouter('POST', '/admin/posts/(\d+)', 'admin\PostController@update');
$router->addRouter('POST', '/admin/posts/(\d+)/delete', 'admin\PostController@delete');
$router->addRouter('GET', '/admin/categories', 'admin\CategoryController@index');
$router->addRouter('GET', '/admin/comments', 'admin\CommentController@index');
$router->addRouter('GET', '/admin/users', 'admin\UserController@index');

// Xử lý yêu cầu
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);