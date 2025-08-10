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
        
        // Debug
        echo "<!-- Debug: URI = '$uri', Method = '$method' -->\n";
        
        foreach ($this->routes as $route){
            echo "<!-- Debug: Checking route {$route['method']} {$route['pattern']} -->\n";
            
            if ($route['method'] === $method && preg_match("#^{$route['pattern']}$#", $uri, $matches)) {
                echo "<!-- Debug: Route matched! -->\n";
                
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
                
                echo "<!-- Debug: Controller file = '$controllerFile' -->\n";
                echo "<!-- Debug: Controller class = '$controllerClass' -->\n";
                
                if (file_exists($controllerFile)) {
                    require_once $controllerFile;
                    
                    $controllerInstance = new $controllerClass();
                    call_user_func_array([$controllerInstance, $action], $matches);
                    return;
                } else {
                    // Debug: hiển thị thông tin lỗi
                    echo "Controller file not found: $controllerFile<br>";
                    echo "Controller class: $controllerClass<br>";
                    echo "URI: $uri<br>";
                    echo "Method: $method<br>";
                    return;
                }
            }
        }
        http_response_code(404);
        echo "404 Not Found - URI: $uri, Method: $method";
    }
}
?>