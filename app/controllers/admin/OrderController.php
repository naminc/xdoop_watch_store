<?php
namespace controllers\admin;

use core\BaseController;

class OrderController extends BaseController
{
    public function index()
    {
        $data['hello'] = 'Hello World, this is Order Controller';
        $this->view('admin/order/index', $data);
    }
}