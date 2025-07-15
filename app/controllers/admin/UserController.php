<?php
namespace controllers\admin;

use core\BaseController;
use models\User;

class UserController extends BaseController
{
    private $userModel;
    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }
    public function index()
    {
        $data['users'] = $this->userModel->getAll();
        $this->view('admin/user/index', $data);
    }
    public function delete($id)
    {
        $result = $this->userModel->delete($id);
        if ($result) {
            $data['success'] = 'Xóa người dùng thành công';
            $data['redirect'] = '/admin/user/index';
        } else {
            $data['error'] = 'Xóa người dùng thất bại';
            $data['redirect'] = '/admin/user/index';
        }
        $this->view('admin/user/index', $data);
    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
            $fullname = $_POST['fullname'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $phone = $_POST['phone'];
            $role = $_POST['role'];
            $status = $_POST['status'];
            $ip = $_POST['ip_address'];
            $user_agent = $_POST['user_agent'];
            $result = $this->userModel->create($fullname, $username, $email, $password, $phone, $role, $status, $ip, $user_agent);
            if ($result) {
                $data['success'] = 'Thêm người dùng thành công';
                $data['redirect'] = '/admin/user/index';
            } else {
                $data['error'] = 'Thêm người dùng thất bại';
                $data['redirect'] = '/admin/user/create';
            }
        }
        $this->view('admin/user/create');
    }

}
