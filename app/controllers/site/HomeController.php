<?php
namespace controllers\site;

use core\BaseController;
use models\Product;

class HomeController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $productM = new Product();
        $data['products'] = $productM->getAll();
        $this->view('site/home/index', $data);
    }
}