<?php
namespace core;

class Router
{
    public function run() // chạy router
    {
        $url = isset($_GET['url']) ? trim($_GET['url'], '/') : ''; // lấy url
        $url = filter_var($url, FILTER_SANITIZE_URL); // lọc url
        $segments = $url === '' ? [] : explode('/', $url); // tách url thành các phần

        $area = 'site'; // area
        $controller = 'home'; // controller
        $method = 'index'; // method
        $params = []; // params

        if (!empty($segments)) { // kiểm tra xem có phần tử trong segments không
            if ($segments[0] === 'admin') { // kiểm tra xem phần tử đầu tiên có phải là admin không
                $area = 'admin'; // area
                $controller = $segments[1] ?? 'home'; // controller
                $method = $segments[2] ?? 'index'; // method
                $params = array_slice($segments, 3); // params
            } else {
                $controller = $segments[0] ?? 'home'; // controller
                $method = $segments[1] ?? 'index'; // method
                $params = array_slice($segments, 2); // params
            }
        }
        $controllerName = ucfirst($controller) . 'Controller'; // tên controller
        $namespace = "\\controllers\\$area"; // namespace
        $class = $namespace . "\\" . $controllerName; // tên class
        $controllerPath = "../app/controllers/$area/$controllerName.php"; // đường dẫn controller

        if (file_exists($controllerPath)) { // kiểm tra xem file controller có tồn tại không
            require_once $controllerPath; // yêu cầu file controller
            $controllerObject = new $class(); // khởi tạo controller

            if (method_exists($controllerObject, $method)) { // kiểm tra xem phương thức có tồn tại không
                call_user_func_array([$controllerObject, $method], $params); // gọi phương thức
            } else {
                http_response_code(404); // trả về mã lỗi 404
                echo "404 not found"; // hiển thị thông báo lỗi
            }
        } else {
            http_response_code(404); // trả về mã lỗi 404
            echo "404 not found"; // hiển thị thông báo lỗi
        }
    }
}