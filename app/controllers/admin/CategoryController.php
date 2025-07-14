<?php
namespace controllers\admin;

use core\BaseController;

class CategoryController extends BaseController
{
    public function index()
    {
        $data['hello'] = 'Hello World, this is Category Controller';
        $this->view('admin/category/index', $data);
    }
}