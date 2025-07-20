<?php
namespace core;

use models\Setting;
use models\Category;
use models\Cart;

class BaseController
{
    protected $setting = [];
    protected $categories = [];
    protected $cartCount = 0;
    public function __construct()
    {
        $settingModel = new Setting();
        $this->setting = $settingModel->getSetting();
        $categoryModel = new Category();
        $this->categories = $categoryModel->getAll();
        if (isset($_SESSION['user'])) {
            $cartModel = new Cart();
            $this->cartCount = $cartModel->getCartCount($_SESSION['user']['id']);
        }
    }
    protected function view($viewPath, $data = [])
    {
        $data['setting'] = $this->setting;
        $data['categories'] = $this->categories;
        $data['cartCount'] = $this->cartCount;
        extract($data);
        $path = "../app/views/" . $viewPath . ".php";
        if (file_exists($path)) {
            require $path;
        } else {
            echo "View not found: $path";
        }
    }
}