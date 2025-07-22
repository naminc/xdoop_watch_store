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
        $host = "localhost"; // host
        $user = "root"; // user
        $pass = ""; // pass
        $dbname = "ruiz-watch"; // dbname

        $this->conn = new mysqli($host, $user, $pass, $dbname); // kết nối đến database

        if ($this->conn->connect_error) { // kiểm tra xem có lỗi kết nối không
            die("Kết nối thất bại: " . $this->conn->connect_error); // hiển thị lỗi kết nối
        }

        $this->conn->set_charset("utf8"); // set charset
    }

    public static function getInstance() // lấy instance của database
    {
        if (self::$instance === null) { // kiểm tra xem instance đã tồn tại chưa
            self::$instance = new Database(); // khởi tạo instance
        }
        return self::$instance->conn; // trả về instance
    }
}