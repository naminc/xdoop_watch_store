<?php
namespace controllers\site;

use core\BaseController;

class PromoController extends BaseController
{
    public function index()
    {
        $data['breadcrumbs'] = 'Khuyến mãi';
        $this->view('site/promo', $data);
    }
}
