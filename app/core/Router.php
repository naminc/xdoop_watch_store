<?php
namespace core;

class Router
{
    public function run()
    {
        $url = isset($_GET['url']) ? trim($_GET['url'], '/') : '';
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $segments = $url === '' ? [] : explode('/', $url);

        $area = 'site';
        $controller = 'home';
        $method = 'index';
        $params = [];

        if (!empty($segments)) {
            if ($segments[0] === 'admin') {
                $area = 'admin';
                $controller = $segments[1] ?? 'home';
                $method = $segments[2] ?? 'index';
                $params = array_slice($segments, 3);
            } else {
                $controller = $segments[0] ?? 'home';
                $method = $segments[1] ?? 'index';
                $params = array_slice($segments, 2);
            }
        }
        $controllerName = ucfirst($controller) . 'Controller';
        $namespace = "\\controllers\\$area";
        $class = $namespace . "\\" . $controllerName;
        $controllerPath = "../app/controllers/$area/$controllerName.php";

        if (file_exists($controllerPath)) {
            require_once $controllerPath;
            $controllerObject = new $class();

            if (method_exists($controllerObject, $method)) {
                call_user_func_array([$controllerObject, $method], $params);
            } else {
                http_response_code(404);
                echo "404 not found";
            }
        } else {
            http_response_code(404);
            echo "404 not found";
        }
    }
}