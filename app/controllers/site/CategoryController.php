<?php
namespace controllers\site;

use core\BaseController;
use models\Category;
use models\Product;

class CategoryController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function detail($slug = '')
    {
        $categoryM = new Category();
        $categoryM->setSlug($slug);
        $category = $categoryM->findBySlug();
        if (!$category) {
            http_response_code(404);
            echo "404 - Danh mục không tồn tại.";
            return;
        }
        $productM = new Product();
        $productM->setCategoryId($category['id']);
        $data['products'] = $productM->getProductByCategory();
        $data['detailCategory'] = $category;
        $data['breadcrumbs'] = $category['name'];
        $this->view('site/category/detail', $data);
    }
}