<?php
namespace core;

use models\Setting;

class BaseController
{
    protected $setting = [];

    public function __construct()
    {
        $settingModel = new Setting();
        $this->setting = $settingModel->getSetting();
    }
    protected function view($viewPath, $data = [])
    {
        $data['setting'] = $this->setting;
        extract($data);
        $path = "../app/views/" . $viewPath . ".php";
        if (file_exists($path)) {
            require $path;
        } else {
            echo "View not found: $path";
        }
    }
}
