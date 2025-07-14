<?php
namespace controllers\admin;

use core\BaseController;

class ProductController extends BaseController
{
    public function index()
    {
        $data['hello'] = 'Hello World, this is Product Controller';
        $this->view('admin/product/index', $data);
    }
}