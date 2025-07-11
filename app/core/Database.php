<?php
namespace core;

use mysqli;
use Exception;

class Database
{
    private static $instance = null;
    private $conn;

    private function __construct()
    {
        $host = "localhost";
        $user = "root";
        $pass = "";
        $dbname = "ruiz-watch";

        $this->conn = new mysqli($host, $user, $pass, $dbname);

        if ($this->conn->connect_error) {
            die("Kết nối thất bại: " . $this->conn->connect_error);
        }

        $this->conn->set_charset("utf8");
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->conn;
    }
}
