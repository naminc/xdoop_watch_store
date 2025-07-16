<?php
namespace controllers\site;

use core\BaseController;

class ContactController extends BaseController
{
    public function index()
    {
        $data['breadcrumbs'] = 'Liên hệ';
        $this->view('site/contact', $data);
    }
}
