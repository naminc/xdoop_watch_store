<?php
namespace controllers\site;

use core\BaseController;
use models\Order;
use models\User;
class AccountController extends BaseController
{
    private $orderModel;
    private $userModel;
    public function __construct()
    {
        parent::__construct();
        $this->orderModel = new Order();
        $this->userModel = new User();
    }
    public function index()
    {
        $data['orders'] = $this->orderModel->getOrdersByUserId($_SESSION['user']['id']);
        $data['breadcrumbs'] = 'Tài khoản';
        $this->view('site/account/index', $data);
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update-info'])) {
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $checkEmail = $this->userModel->checkEmailUpdate($email, $_SESSION['user']['id']);
            if ($checkEmail > 0) {
                $data['error'] = 'Email đã tồn tại';
                $data['redirect'] = '/account';
                $this->view('site/account/index', $data);
                return;
            }
            $this->userModel->updateInfo($_SESSION['user']['id'], $fullname, $email, $phone);
            $data['success'] = 'Cập nhật thông tin thành công vui lòng đăng nhập lại';
            $data['redirect'] = '/auth/logout';
            $this->view('site/account/index', $data);
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change-password'])) {
            $password = $_POST['password'];
            $newPassword = $_POST['new-password'];
            $confirmPassword = $_POST['confirm-password'];
            if ($newPassword != $confirmPassword || empty($newPassword) || empty($confirmPassword) || empty($password)) {
                $data['error'] = 'Mật khẩu mới và xác nhận mật khẩu không khớp';
                $data['redirect'] = '/account';
                $this->view('site/account/index', $data);
                return;
            }
            $user = $this->userModel->getByID($_SESSION['user']['id']);
            if (password_verify($password, $user['password'])) {
                $this->userModel->updatePassword($_SESSION['user']['id'], $newPassword);
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