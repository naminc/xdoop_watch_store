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

        if ($this->conn->connect_error) {
            die("Kết nối thất bại: " . $this->conn->connect_error);
        }
        $this->conn->set_charset($charset);
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->conn;
    }
}