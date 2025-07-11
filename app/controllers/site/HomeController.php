<?php
namespace controllers\site;

use core\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        $this->view('site/home/index');
    }
}