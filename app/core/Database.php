<?php
namespace core;

use mysqli;
use Exception;

class Database
{
    private static $instance = null; // instance
    private $conn; // conn

    private function __construct() // constructor
    {
        $config = require_once __DIR__ . '/../config/config.php';
        $host = $config['database']['host']; // host
        $user = $config['database']['user']; // user
        $pass = $config['database']['pass']; // pass
        $dbname = $config['database']['dbname']; // dbname
        $charset = $config['database']['charset']; // charset
        $this->conn = new mysqli($host, $user, $pass, $dbname); // kết nối đến database

        if ($this->conn->connect_error) { // kiểm tra xem có lỗi kết nối không
            die("Kết nối thất bại: " . $this->conn->connect_error); // hiển thị lỗi kết nối
        }
        $this->conn->set_charset($charset); // set charset
    }

    public static function getInstance() // lấy instance của database
    {
        if (self::$instance === null) { // kiểm tra xem instance đã tồn tại chưa
            self::$instance = new Database(); // khởi tạo instance
        }
        return self::$instance->conn; // trả về instance
    }
}