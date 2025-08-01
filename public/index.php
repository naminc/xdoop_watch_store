<?php
date_default_timezone_set('Asia/Ho_Chi_Minh'); // set timezone
error_reporting(0); // tắt các thông báo lỗi
if (session_status() == PHP_SESSION_NONE) session_start(); // kiểm tra xem session đã khởi tạo chưa, nếu chưa thì khởi tạo
spl_autoload_register(function ($class) { // tự động nạp các class
    require_once "../app/" . str_replace("\\", "/", $class) . ".php"; // nạp class từ thư mục app
});
use core\Router; // nạp class Router
$app = new Router(); // khởi tạo router
$app->run(); // chạy router