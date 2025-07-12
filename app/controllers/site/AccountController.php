<?php
namespace controllers\site;

use core\BaseController;

class AccountController extends BaseController
{
    public function index()
    {
        $this->view('site/account/index');
    }
}