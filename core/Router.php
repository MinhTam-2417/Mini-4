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
            if ($route['method']=== $method && preg_match("#^{$route['pattern']}$#", $uri, $matches)) {
                list($controller, $action) = explode('@', $route['controller']);                

                array_shift($matches); // loại bỏ phần đầu tiên (URI)
                $controllerFile = __DIR__ . "/../controllers/$controller.php";
                if (file_exists($controllerFile)) {
                    // Require core files
                    require_once __DIR__ . '/Controller.php';
                    require_once __DIR__ . '/Database.php';
                    require_once __DIR__ . '/Model.php';
                    
                    // Require model files
                    require_once __DIR__ . '/../models/User.php';
                    require_once __DIR__ . '/../models/Post.php';
                    require_once __DIR__ . '/../models/Category.php';
                    require_once __DIR__ . '/../models/Comment.php';
                    
                    require_once $controllerFile;
                    
                    // Xử lý namespace cho controller
                    $controllerParts = explode('/', $controller);
                    $controllerClass = end($controllerParts);
                    
                    // Kiểm tra namespace
                    if (strpos($controller, 'admin/') === 0) {
                        $controllerClass = 'admin\\' . $controllerClass;
                    } elseif (strpos($controller, 'client/') === 0) {
                        $controllerClass = 'client\\' . $controllerClass;
                    }
                    
                    $controllerInstance = new $controllerClass();
                    call_user_func_array([$controllerInstance, $action], $matches);
                    return;
                }
            }
        }
        http_response_code(404);
        echo "404 Not Found";
    }
}
?>