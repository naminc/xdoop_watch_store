<?php
namespace controllers\site;

use core\BaseController;
use models\Order;
use models\User;
use models\OrderItem;
class AccountController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        $orderM = new Order(); 
        $orderM->setUserId($_SESSION['user']['id']); 
        $data['orders'] = $orderM->getOrdersByUserId(); 
        $data['breadcrumbs'] = 'Tài khoản'; 
        $this->view('site/account/index', $data); 
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update-info'])) {
            $userM = new User(); 
            $userM->setFullname($_POST['fullname']); 
            $userM->setEmail($_POST['email']); 
            $userM->setPhone($_POST['phone']); 
            $checkEmail = $userM->checkEmailUpdate();
            if ($checkEmail > 0) { 
                $data['error'] = 'Email đã tồn tại';
                $data['redirect'] = '/account';
                $this->view('site/account/index', $data); 
                return;
            }
            $userM->updateInfo(); 
            $data['success'] = 'Cập nhật thông tin thành công vui lòng đăng nhập lại';
            $data['redirect'] = '/auth/logout';
            $this->view('site/account/index', $data); 
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change-password'])) {
            $userM = new User(); 
            $password = $_POST['password']; 
            $userM->setPassword($_POST['new-password']); 
            $confirmPassword = $_POST['confirm-password']; 
            $userM->setId($_SESSION['user']['id']); 
            if ($userM->getPassword() != $confirmPassword || empty($userM->getPassword()) || empty($confirmPassword) || empty($password)) { 
                $data['error'] = 'Mật khẩu mới và xác nhận mật khẩu không khớp';
                $data['redirect'] = '/account';
                $this->view('site/account/index', $data); 
                return;
            }
            $user = $userM->getByID(); 
            if (password_verify($password, $user['password'])) { 
                $userM->updatePassword(); 
                $data['success'] = 'Cập nhật mật khẩu thành công vui lòng đăng nhập lại';
                $data['redirect'] = '/auth/logout';
                $this->view('site/account/index', $data); 
                return;
            } else {
                $data['error'] = 'Mật khẩu hiện tại không chính xác';
                $data['redirect'] = '/account';
                $this->view('site/account/index', $data); 
                return;
            }
        }
    }
}