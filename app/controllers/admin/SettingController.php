<?php
namespace controllers\admin;

use core\BaseController;
use models\Setting;

class SettingController extends BaseController
{
    public function __construct()
    {
        parent::__construct(); // gọi constructor của BaseController
    }
    public function index()
    {
        $this->view('admin/setting'); // hiển thị view setting
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            $settingModel = new Setting(); // khởi tạo model Setting
            $settingModel->setId(1); // set id
            $settingModel->setTitle($_POST['title'] ?? ''); // set title
            $settingModel->setKeyword($_POST['keyword'] ?? ''); // set keyword
            $settingModel->setDescription($_POST['description'] ?? ''); // set description
            $settingModel->setDomain($_POST['domain'] ?? ''); // set domain
            $settingModel->setBrand($_POST['brand'] ?? ''); // set brand
            $settingModel->setOwner($_POST['owner'] ?? ''); // set owner
            $settingModel->setEmail($_POST['email'] ?? ''); // set email
            $settingModel->setPhone($_POST['phone'] ?? ''); // set phone
            $settingModel->setAddress($_POST['address'] ?? ''); // set address
            $settingModel->setLogo($_POST['logo'] ?? ''); // set logo
            $settingModel->setIcon($_POST['icon'] ?? ''); // set icon
            $settingModel->setMaintenance($_POST['maintenance'] ?? ''); // set maintenance
            if (empty($settingModel->getTitle()) || empty($settingModel->getKeyword()) || empty($settingModel->getDescription()) || empty($settingModel->getDomain()) || empty($settingModel->getBrand()) || empty($settingModel->getOwner()) || empty($settingModel->getEmail()) || empty($settingModel->getPhone()) || empty($settingModel->getAddress()) || empty($settingModel->getLogo()) || empty($settingModel->getIcon()) || empty($settingModel->getMaintenance())) {
                $data['error'] = 'Vui lòng điền đầy đủ thông tin.';
            } else {
                $settingModel->updateSetting(); // cập nhật setting
                $data['success'] = 'Cập nhật thành công.'; 
                $data['redirect'] = '/admin/setting';
            }
        }
        $this->view('admin/setting', $data); // hiển thị view setting
    }
}