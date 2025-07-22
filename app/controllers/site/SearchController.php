<?php
namespace controllers\site;

use core\BaseController;
use models\Product;

class SearchController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function detail()
    {
        if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['keyword'])){
            $productM = new Product();
            $productM->setName(trim($_GET['keyword']));
            $products = $productM->searchProduct();
            if (empty($products)) {
                $data['noResult'] = 'Không tìm thấy sản phẩm nào phù hợp.';
            } else {
                $data['products'] = $products;
                $data['noResult'] = '';
            }
        }
        $data['keyword'] = $_GET['keyword'];
        $data['breadcrumbs'] = 'Kết quả tìm kiếm: ' . $_GET['keyword'];
        $this->view('site/search/detail', $data);
    }
}