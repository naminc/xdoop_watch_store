<?php
namespace controllers\site;

use core\BaseController;

class AboutController extends BaseController
{
    public function index()
    {
        $data['breadcrumbs'] = 'Giới thiệu'; // lấy breadcrumbs
        $this->view('site/about', $data); // hiển thị view about
    }
}
