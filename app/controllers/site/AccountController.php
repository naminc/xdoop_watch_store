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
        $orderM = new Order(); // khởi tạo model Order
        $orderM->setUserId($_SESSION['user']['id']); // set id
        $data['orders'] = $orderM->getOrdersByUserId(); // lấy đơn hàng theo id
        $data['breadcrumbs'] = 'Tài khoản'; // lấy breadcrumbs
        $this->view('site/account/index', $data); // hiển thị view index
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update-info'])) {
            $userM = new User(); // khởi tạo model User
            $userM->setFullname($_POST['fullname']); // set fullname
            $userM->setEmail($_POST['email']); // set email
            $userM->setPhone($_POST['phone']); // set phone
            $checkEmail = $userM->checkEmailUpdate();
            if ($checkEmail > 0) { // kiểm tra xem email đã tồn tại chưa
                $data['error'] = 'Email đã tồn tại';
                $data['redirect'] = '/account';
                $this->view('site/account/index', $data); // hiển thị view index
                return;
            }
            $userM->updateInfo(); // cập nhật thông tin
            $data['success'] = 'Cập nhật thông tin thành công vui lòng đăng nhập lại';
            $data['redirect'] = '/auth/logout';
            $this->view('site/account/index', $data); // hiển thị view index
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change-password'])) {
            $userM = new User(); // khởi tạo model User
            $password = $_POST['password']; // lấy password
            $userM->setPassword($_POST['new-password']); // set password
            $confirmPassword = $_POST['confirm-password']; // lấy confirm password
            $userM->setId($_SESSION['user']['id']); // set id
            if ($userM->getPassword() != $confirmPassword || empty($userM->getPassword()) || empty($confirmPassword) || empty($password)) { // kiểm tra xem password có khớp không
                $data['error'] = 'Mật khẩu mới và xác nhận mật khẩu không khớp';
                $data['redirect'] = '/account';
                $this->view('site/account/index', $data); // hiển thị view index
                return;
            }
            $user = $userM->getByID(); // lấy thông tin người dùng
            if (password_verify($password, $user['password'])) { // kiểm tra xem password có khớp không
                $userM->updatePassword(); // cập nhật password
                $data['success'] = 'Cập nhật mật khẩu thành công vui lòng đăng nhập lại';
                $data['redirect'] = '/auth/logout';
                $this->view('site/account/index', $data); // hiển thị view index
                return;
            } else {
                $data['error'] = 'Mật khẩu hiện tại không chính xác';
                $data['redirect'] = '/account';
                $this->view('site/account/index', $data); // hiển thị view index
                return;
            }
        }
    }
}