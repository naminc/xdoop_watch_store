<?php
namespace controllers\site;

use core\BaseController;

class AboutController extends BaseController
{
    public function index()
    {
        $this->view('site/about');
    }
}
