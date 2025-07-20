<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
spl_autoload_register(function ($class) {
    require_once "../app/" . str_replace("\\", "/", $class) . ".php";
});
use core\Router;
$app = new Router();
$app->run();