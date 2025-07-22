<?php
namespace core;

abstract class Model
{
    protected $db; // db

    public function __construct() // constructor
    {
        $this->db = Database::getInstance(); // lấy instance của database
    }

}