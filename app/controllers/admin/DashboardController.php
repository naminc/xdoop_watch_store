<?php
namespace controllers\admin;

use core\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        $this->view('admin/dashboard');
    }
}
