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
        date_default_timezone_set('Asia/Ho_Chi_Minh'); // set timezone
        $settingM = new Setting();
        $this->setting = $settingM->getSetting();

        if ($this->setting['maintenance'] == 'on') {
            die('Website đang được bảo trì, vui lòng quay lại sau.');
        }
        $categoryM = new Category();
        $this->categories = $categoryM->getAll();
        if (isset($_SESSION['user'])) {
            $cartM = new Cart();
            $cartM->setUserId($_SESSION['user']['id']);
            $this->cartCount = $cartM->getCartCount();
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