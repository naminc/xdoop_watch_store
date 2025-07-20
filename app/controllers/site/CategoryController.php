<?php
namespace controllers\site;

use core\BaseController;
use models\Category;
use models\Product;

class CategoryController extends BaseController
{
    private $categoryModel;
    private $productModel;

    public function __construct()
    {
        parent::__construct();
        $this->categoryModel = new Category();
        $this->productModel = new Product();
    }

    public function detail($slug = '')
    {
        $category = $this->categoryModel->findBySlug($slug);
        if (!$category) {
            http_response_code(404);
            echo "404 - Danh mục không tồn tại.";
            return;
        }
        $products = $this->productModel->getProductByCategory($category['id']);
        $data['detailCategory'] = $category;
        $data['products'] = $products;
        $data['breadcrumbs'] = $category['name'];
        $this->view('site/category/detail', $data);
    }
}