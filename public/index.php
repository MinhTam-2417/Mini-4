<?php 
session_start();

//Điểm vào chính của ứng dụng
require_once '../core/Router.php';
require_once '../config/database.php';

//khởi tạo router
$router = new Router();

//định nghĩa các router cho client (khách hàng)
$router->addRouter('GET', '/', 'client/HomeController@index');
$router->addRouter('GET', '/post/create', 'client/PostController@create');
$router->addRouter('POST', '/post/store', 'client/PostController@store');
$router->addRouter('GET', '/post/(\d+)', 'client/PostController@show');
$router->addRouter('GET', '/post/(\d+)/edit', 'client/PostController@edit');
$router->addRouter('POST', '/post/(\d+)/update', 'client/PostController@update');
$router->addRouter('POST', '/post/(\d+)/delete', 'client/PostController@delete');
$router->addRouter('POST', '/post/(\d+)/comment', 'client/PostController@comment');
$router->addRouter('GET', '/search', 'client/SearchController@index');
$router->addRouter('GET', '/profile', 'client/ProfileController@index');
$router->addRouter('POST', '/profile/update', 'client/ProfileController@update');
$router->addRouter('POST', '/profile/change-password', 'client/ProfileController@changePassword');
$router->addRouter('GET', '/user', 'client/ProfileController@index'); // Redirect /user to /profile
$router->addRouter('GET', '/user/(\d+)', 'client/ProfileController@show'); // Xem chi tiết user theo ID
$router->addRouter('GET', '/login', 'client/AuthController@login');
$router->addRouter('POST', '/login', 'client/AuthController@doLogin');
$router->addRouter('GET', '/register', 'client/AuthController@register');
$router->addRouter('POST', '/register', 'client/AuthController@doRegister');
$router->addRouter('GET', '/logout', 'client/AuthController@logout');

// Routes cho reset password
$router->addRouter('GET', '/forgot-password', 'client/PasswordController@showForgotPassword');
$router->addRouter('POST', '/forgot-password', 'client/PasswordController@forgotPassword');
$router->addRouter('GET', '/reset-password', 'client/PasswordController@showResetPassword');
$router->addRouter('POST', '/reset-password', 'client/PasswordController@resetPassword');

// Routes cho save và share
$router->addRouter('POST', '/post/save', 'client/SaveShareController@savePost');
$router->addRouter('POST', '/post/unsave', 'client/SaveShareController@unsavePost');
$router->addRouter('POST', '/post/share', 'client/SaveShareController@sharePost');
$router->addRouter('GET', '/post/save-status', 'client/SaveShareController@getSaveStatus');
$router->addRouter('GET', '/saved-posts', 'client/SaveShareController@savedPosts');
$router->addRouter('GET', '/share-history', 'client/SaveShareController@shareHistory');

// Routes cho like
$router->addRouter('GET', '/likes', 'client/LikeController@myLikes');
$router->addRouter('POST', '/like/toggle', 'client/LikeController@toggle');
$router->addRouter('POST', '/like/add', 'client/LikeController@like');
$router->addRouter('POST', '/like/remove', 'client/LikeController@unlike');
$router->addRouter('GET', '/like/count/(\d+)', 'client/LikeController@getLikeCount');
$router->addRouter('GET', '/like/users/(\d+)', 'client/LikeController@getUsersWhoLiked');

// Routes cho comment
$router->addRouter('POST', '/comment/add', 'client/CommentController@add');
$router->addRouter('GET', '/comment/delete/(\d+)', 'client/CommentController@delete');

// Routes cho ẩn bài viết
$router->addRouter('POST', '/hide/toggle', 'client/HidePostController@toggleHide');
$router->addRouter('POST', '/hide/post', 'client/HidePostController@hidePost');
$router->addRouter('POST', '/hide/unhide', 'client/HidePostController@unhidePost');
$router->addRouter('GET', '/hide/status', 'client/HidePostController@getHideStatus');
$router->addRouter('GET', '/hidden-posts', 'client/HidePostController@hiddenPosts');

//Định nghĩa các route cho admin
$router->addRouter('GET', '/admin', 'admin\DashboardController@index');
$router->addRouter('GET', '/admin/posts', 'admin\PostController@index');
$router->addRouter('GET', '/admin/posts/create', 'admin\PostController@create');
$router->addRouter('POST', '/admin/posts', 'admin\PostController@store');
$router->addRouter('GET', '/admin/posts/(\d+)/edit', 'admin\PostController@edit');
$router->addRouter('POST', '/admin/posts/(\d+)', 'admin\PostController@update');
$router->addRouter('POST', '/admin/posts/(\d+)/delete', 'admin\PostController@delete');
$router->addRouter('GET', '/admin/categories', 'admin\CategoryController@index');
$router->addRouter('GET', '/admin/categories/create', 'admin\CategoryController@create');
$router->addRouter('POST', '/admin/categories', 'admin\CategoryController@store');
$router->addRouter('GET', '/admin/categories/(\d+)/edit', 'admin\CategoryController@edit');
$router->addRouter('POST', '/admin/categories/(\d+)', 'admin\CategoryController@update');
$router->addRouter('POST', '/admin/categories/(\d+)/delete', 'admin\CategoryController@delete');
$router->addRouter('GET', '/admin/comments', 'admin\CommentController@index');
$router->addRouter('POST', '/admin/comments/delete/(\d+)', 'admin\CommentController@delete');
$router->addRouter('GET', '/admin/users', 'admin\UserController@index');
$router->addRouter('POST', '/admin/users/(\d+)/delete', 'admin\UserController@delete');

// Routes cho quản lý likes
$router->addRouter('GET', '/admin/likes', 'admin\LikeController@index');
$router->addRouter('POST', '/admin/likes/(\d+)/delete', 'admin\LikeController@delete');
$router->addRouter('GET', '/admin/likes/post/(\d+)', 'admin\LikeController@byPost');
$router->addRouter('GET', '/admin/likes/user/(\d+)', 'admin\LikeController@byUser');
$router->addRouter('GET', '/admin/likes/stats', 'admin\LikeController@stats');

// Routes cho quản lý tags
$router->addRouter('GET', '/admin/tags', 'admin\TagController@index');
$router->addRouter('GET', '/admin/tags/create', 'admin\TagController@create');
$router->addRouter('POST', '/admin/tags/create', 'admin\TagController@create');
$router->addRouter('GET', '/admin/tags/edit/(\d+)', 'admin\TagController@edit');
$router->addRouter('POST', '/admin/tags/edit/(\d+)', 'admin\TagController@edit');
$router->addRouter('GET', '/admin/tags/delete/(\d+)', 'admin\TagController@delete');
$router->addRouter('GET', '/admin/tags/api', 'admin\TagController@apiGetTags');

// Xử lý yêu cầu
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);