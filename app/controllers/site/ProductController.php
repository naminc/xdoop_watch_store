<?php
namespace controllers\site;

use core\BaseController;
use models\Category;
use models\Product;

class ProductController extends BaseController
{
    private $productModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
    }

    public function detail($slug = '')
    {
        $product = $this->productModel->getBySlug($slug);
        if (!$product) {
            http_response_code(404);
            echo "404 - Sản phẩm không tồn tại.";
            return;
        }
        $data['product'] = $product;
        $data['breadcrumbs'] = 'Chi tiết sản phẩm';
        $this->view('site/product/detail', $data);
    }
}