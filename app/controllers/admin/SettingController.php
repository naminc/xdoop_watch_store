<?php
namespace controllers\admin;

use core\BaseController;
use models\Setting;

class SettingController extends BaseController
{
    private $settingModel;
    public function __construct()
    {
        parent::__construct();
        $this->settingModel = new Setting();
    }
    public function index()
    {
        $this->view('admin/setting');
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            $title = $_POST['title'] ?? '';
            $keyword = $_POST['keyword'] ?? '';
            $description = $_POST['description'] ?? '';
            $domain = $_POST['domain'] ?? '';
            $brand = $_POST['brand'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $logo = $_POST['logo'] ?? '';
            $icon = $_POST['icon'] ?? '';
            $maintenance = $_POST['maintenance'] ?? '';
            if (empty($title) || empty($keyword) || empty($description) || empty($domain) || empty($brand) || empty($email) || empty($phone) || empty($address) || empty($logo) || empty($icon) || empty($maintenance)) {
                $data['error'] = 'Vui lòng điền đầy đủ thông tin.';
            } else {
                $this->settingModel->updateSetting([
                    'title' => $title,
                    'keyword' => $keyword,
                    'description' => $description,
                    'domain' => $domain,
                    'brand' => $brand,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                    'logo' => $logo,
                    'icon' => $icon,
                    'maintenance' => $maintenance,
                ]);
                $data['success'] = 'Cập nhật thành công.';
                $data['redirect'] = '/admin/setting';
            }
        }
        $this->view('admin/setting', $data);
    }
}