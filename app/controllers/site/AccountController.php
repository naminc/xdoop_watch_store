<?php
namespace controllers\site;

use core\BaseController;

class AccountController extends BaseController
{
    public function index()
    {
        $data['breadcrumbs'] = 'Tài khoản';
        $this->view('site/account/index', $data);
    }
}