<?php

namespace controllers\site;

use core\BaseController;
use models\User;

class AuthController extends BaseController
{
    public function __construct()
    {
        parent::__construct(); // gọi constructor của BaseController
    }

    public function login()
    {
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
            $userM = new User(); // khởi tạo model User
            $userM->setUsername($_POST['username'] ?? ''); // set username
            $userM->setPassword($_POST['password'] ?? ''); // set password
            if (empty($userM->getUsername()) || empty($userM->getPassword())) { 
                $data['error'] = 'Tên đăng nhập và mật khẩu không được để trống.';
            } else if (strlen($userM->getUsername()) < 6) {
                $data['error'] = 'Tên đăng nhập phải có ít nhất 6 ký tự.';
            } else if (strlen($userM->getPassword()) < 6) {
                $data['error'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
            } else {
                $user = $userM->checkLogin(); // kiểm tra xem tên đăng nhập và mật khẩu có khớp không
                if ($user) { // kiểm tra xem tên đăng nhập và mật khẩu có khớp không
                    $_SESSION['user'] = $user; // lưu thông tin người dùng vào session
                    $data['success'] = 'Đăng nhập thành công!';
                    $data['redirect'] = '/home';
                } else {
                    $data['error'] = 'Tên đăng nhập hoặc mật khẩu không chính xác.';
                }
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
            $userM = new User(); // khởi tạo model User
            $userM->setUsername($_POST['username'] ?? ''); // set username
            $userM->setFullname(''); // set fullname
            $userM->setPhone(''); // set phone
            $userM->setEmail($_POST['email'] ?? ''); // set email
            $userM->setPassword($_POST['password'] ?? ''); // set password
            $confirm_password = $_POST['confirm_password'] ?? ''; // lấy confirm password
            $userM->setRole('user'); // set role
            $userM->setStatus(1); // set status
            $userM->setIpAddress(filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) ?: 'unknown'); // set ip address
            $userM->setUserAgent(substr($_SERVER['HTTP_USER_AGENT'] ?? 'unknown', 0, 255)); // set user agent

            if (!$userM->getUsername() || !$userM->getEmail() || !$userM->getPassword() || !$confirm_password) { // kiểm tra xem tên đăng nhập, email, password và confirm password có rỗng không
                $data['error'] = 'Vui lòng điền đầy đủ thông tin.';
            } elseif (strlen($userM->getUsername()) < 6) { // kiểm tra xem tên đăng nhập có ít nhất 6 ký tự không
                $data['error'] = 'Tên đăng nhập phải có ít nhất 6 ký tự.';
            } elseif (strlen($userM->getPassword()) < 6) { // kiểm tra xem password có ít nhất 6 ký tự không
                $data['error'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
            } elseif ($userM->getPassword() !== $confirm_password) { // kiểm tra xem password và confirm password có khớp không
                $data['error'] = 'Mật khẩu và xác nhận mật khẩu không khớp.';
            } elseif (!filter_var($userM->getEmail(), FILTER_VALIDATE_EMAIL)) { // kiểm tra xem email có hợp lệ không
                $data['error'] = 'Email không hợp lệ.';
            } elseif ($userM->checkUsername() > 0) { // kiểm tra xem tên đăng nhập đã tồn tại chưa
                $data['error'] = 'Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.';
            } elseif ($userM->checkEmail() > 0) { // kiểm tra xem email đã tồn tại chưa
                $data['error'] = 'Email đã tồn tại. Vui lòng chọn email khác.';
            } else {
                if ($userM->register()) { // đăng ký
                    $data['success'] = 'Đăng ký thành công! Vui lòng đăng nhập để tiếp tục.';
                    $data['redirect'] = '/auth/login';
                } else {
                    $data['error'] = 'Đăng ký thất bại. Vui lòng thử lại.';
                }
            }
        }
        $data['breadcrumbs'] = 'Đăng nhập - Đăng ký'; // lấy breadcrumbs
        $this->view('site/auth/login', $data); // hiển thị view login
    }

    public function logout()
    {
        session_destroy(); // hủy session
        header("Location: /"); // chuyển hướng đến trang chủ
        exit;
    }
}