<?php
namespace controllers\site;

use core\BaseController;
use models\Product;

class ProductController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function detail($slug = '')
    {
        $productM = new Product();
        $productM->setSlug($slug);
        $product = $productM->getBySlug();
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