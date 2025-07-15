<?php
namespace core;

use models\Setting;
use models\Category;

class BaseController
{
    protected $setting = [];
    protected $categories = [];

    public function __construct()
    {
        $settingModel = new Setting();
        $this->setting = $settingModel->getSetting();
        $categoryModel = new Category();
        $this->categories = $categoryModel->getAll();
    }
    protected function view($viewPath, $data = [])
    {
        $data['setting'] = $this->setting;
        $data['categories'] = $this->categories;
        extract($data);
        $path = "../app/views/" . $viewPath . ".php";
        if (file_exists($path)) {
            require $path;
        } else {
            echo "View not found: $path";
        }
    }
}