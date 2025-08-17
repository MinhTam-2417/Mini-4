<?php
class Router{
    private $routes =[];
    // thêm router
    public function addRouter($method, $pattern, $controller){
        $this->routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'controller' => $controller
        ];
    }
    // xử lý yêu cầu
    public function dispatch($uri, $method){
        $uri = parse_url($uri, PHP_URL_PATH);
        
        // Loại bỏ phần /Mini-4/public nếu có
        $uri = preg_replace('#^/Mini-4/public#', '', $uri);
        
        foreach ($this->routes as $route){
            if ($route['method'] === $method && preg_match("#^{$route['pattern']}$#", $uri, $matches)) {
                
                list($controller, $action) = explode('@', $route['controller']);                

                array_shift($matches); // loại bỏ phần đầu tiên (URI)
                
                // Require core files
                require_once __DIR__ . '/Controller.php';
                require_once __DIR__ . '/Database.php';
                require_once __DIR__ . '/Model.php';
                
                // Require model files
                require_once __DIR__ . '/../models/User.php';
                require_once __DIR__ . '/../models/Post.php';
                require_once __DIR__ . '/../models/Category.php';
                require_once __DIR__ . '/../models/Comment.php';
                require_once __DIR__ . '/../models/Like.php';
                require_once __DIR__ . '/../models/Tag.php';
                require_once __DIR__ . '/../models/SavedPost.php';
                require_once __DIR__ . '/../models/SharedPost.php';
                require_once __DIR__ . '/../models/HiddenPost.php';
                
                // Require controller files
                require_once __DIR__ . '/../controllers/client/CommentController.php';
                
                // Xử lý đường dẫn controller
                $controllerFile = '';
                $controllerClass = '';
                
                if (strpos($controller, 'admin\\') === 0) {
                    // Admin controller
                    $controllerName = str_replace('admin\\', '', $controller);
                    $controllerFile = __DIR__ . "/../controllers/admin/$controllerName.php";
                    $controllerClass = 'admin\\' . $controllerName;
                } elseif (strpos($controller, 'client/') === 0) {
                    // Client controller
                    $controllerFile = __DIR__ . "/../controllers/$controller.php";
                    $controllerClass = 'client\\' . str_replace('client/', '', $controller);
                } else {
                    // Default controller (client)
                    $controllerFile = __DIR__ . "/../controllers/client/$controller.php";
                    $controllerClass = 'client\\' . $controller;
                }
                
                if (file_exists($controllerFile)) {
                    require_once $controllerFile;
                    
                    $controllerInstance = new $controllerClass();
                    call_user_func_array([$controllerInstance, $action], $matches);
                    return;
                } else {
                    http_response_code(404);
                    echo "Controller not found";
                    return;
                }
            }
        }
        http_response_code(404);
        echo "404 Not Found - URI: $uri, Method: $method";
    }
}
?>