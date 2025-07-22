<?php

namespace controllers\admin;

use core\BaseController;
use models\User;

class UserController extends BaseController
{
    private $userModel;
    public function __construct()
    {
        parent::__construct(); // gọi constructor của BaseController
        $this->userModel = new User(); // khởi tạo model User
    }
    public function index()
    {
        $data['users'] = $this->userModel->getAll(); // lấy tất cả người dùng
        $this->view('admin/user/index', $data); // hiển thị view index
    }
    public function delete($id)
    {
        $userM = new User(); // khởi tạo model User
        $userM->setId($id); // set id
        $result = $userM->delete(); // xóa người dùng
        if ($result) {
            $data['success'] = 'Xóa người dùng thành công';
            $data['redirect'] = '/admin/user/index';
        } else {
            $data['error'] = 'Xóa người dùng thất bại';
            $data['redirect'] = '/admin/user/index';
        }
        $this->view('admin/user/index', $data); // hiển thị view index
    }
    public function create()
    {
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
            $userM = new User(); // khởi tạo model User
            $userM->setFullname($_POST['fullname']); // set fullname
            $userM->setUsername($_POST['username']); // set username
            $userM->setEmail($_POST['email']); // set email
            $userM->setPassword($_POST['password']); // set password
            $userM->setPhone($_POST['phone']); // set phone
            $userM->setRole($_POST['role']); // set role
            $userM->setStatus($_POST['status']); // set status
            $userM->setIpAddress($_POST['ip_address']); // set ip address
            $userM->setUserAgent($_POST['user_agent']); // set user agent
            if ($userM->checkUsername() > 0) { // kiểm tra xem username đã tồn tại chưa
                $data['error'] = 'Tên người dùng đã tồn tại';
                $data['redirect'] = '/admin/user/create';
            } elseif ($userM->checkEmail() > 0) { // kiểm tra xem email đã tồn tại chưa
                $data['error'] = 'Email đã tồn tại';
                $data['redirect'] = '/admin/user/create';
            } else {
                $result = $userM->create(); // tạo người dùng
                if ($result) {
                    $data['success'] = 'Thêm người dùng thành công';
                    $data['redirect'] = '/admin/user/index';
                } else {
                    $data['error'] = 'Thêm người dùng thất bại';
                    $data['redirect'] = '/admin/user/create';
                }
            }
        }
        $this->view('admin/user/create', $data); // hiển thị view create
    }
    public function edit($id)
    {
        $data = [];
        $userM = new User(); // khởi tạo model User
        $userM->setId($id); // set id
        $data['user'] = $userM->getByID(); // lấy người dùng theo id
        if (!$data['user']) {
            $data['error'] = 'Người dùng không tồn tại';
            $data['redirect'] = '/admin/user/index';
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
            $userM->setFullname($_POST['fullname']); // set fullname
            $userM->setUsername($_POST['username']); // set username
            $userM->setEmail($_POST['email']); // set email
            $userM->setPassword($_POST['password']); // set password
            $userM->setPhone($_POST['phone']); // set phone
            $userM->setRole($_POST['role']); // set role
            $userM->setStatus($_POST['status']); // set status
            $userM->setIpAddress($_POST['ip_address']); // set ip address
            $userM->setUserAgent($_POST['user_agent']); // set user agent

            if ($userM->checkUsernameUpdate() > 0) {
                $data['error'] = 'Tên người dùng đã tồn tại';
                $data['redirect'] = '/admin/user/edit/' . $id;
            } elseif ($userM->checkEmailUpdate() > 0) {
                $data['error'] = 'Email đã tồn tại';
                $data['redirect'] = '/admin/user/edit/' . $id;
            } else {
                if (empty($userM->getPassword())) { // kiểm tra xem password có rỗng không
                    $result = $userM->updateWithoutPassword(); // cập nhật người dùng không có password
                } else {
                    $result = $userM->update(); // cập nhật người dùng
                }
                if ($result) {
                    $data['success'] = 'Cập nhật người dùng thành công';
                    $data['redirect'] = '/admin/user/index';
                } else {
                    $data['error'] = 'Cập nhật người dùng thất bại';
                    $data['redirect'] = '/admin/user/edit/' . $id;
                }
            }
        }
        $this->view('admin/user/edit', $data); // hiển thị view edit
    }
}