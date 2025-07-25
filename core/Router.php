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
        foreach ($this->routes as $route){
            if ($route['method']=== $method && preg_match("#^{$route['pattern']}$#", $uri, $matches)) {
                list($controller, $action) = explode('@', $route['controller']);                

                array_shift($matches); // loại bỏ phần đầu tiên (URI)
                $controllerFile = "../controllers/$controller.php";
                if (file_exists($controllerFile)) { // Sửa lại điều kiện kiểm tra file
                    require_once $controllerFile;
                    $controllerClass = $controller; 
                    $controllerInstance = new $controllerClass();
                    call_user_func_array([$controllerInstance, $action], $matches);
                    return;
                }
                // return call_user_func_array([$controller, 'handle'], $matches);
            }
        }
        http_response_code(404);
        echo "404 Not Found";
    }
}
?>