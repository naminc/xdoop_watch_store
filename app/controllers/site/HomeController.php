<?php
namespace controllers\site;

use core\BaseController;
use models\Product;

class HomeController extends BaseController
{
    private $productModel;
    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
    }

    public function index()
    {
        $products = $this->productModel->getAll();
        $this->view('site/home/index', ['products' => $products]);
    }
}