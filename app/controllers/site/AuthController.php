<?php

namespace controllers\site;

use core\BaseController;
use models\User;

class AuthController extends BaseController
{
    private $userModel;
    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    public function login()
    {
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            if (empty($username) || empty($password)) {
                $data['error'] = 'Tên đăng nhập và mật khẩu không được để trống.';
            } else if (strlen($username) < 6) {
                $data['error'] = 'Tên đăng nhập phải có ít nhất 6 ký tự.';
            } else if (strlen($password) < 6) {
                $data['error'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
            } else {
                $user = $this->userModel->checkLogin($username, $password);
                if ($user) {
                    $_SESSION['user'] = $user;
                    $data['success'] = 'Đăng nhập thành công!';
                    $data['redirect'] = '/home';
                } else {
                    $data['error'] = 'Tên đăng nhập hoặc mật khẩu không chính xác.';
                }
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
            $username         = trim($_POST['username'] ?? '');
            $email            = trim($_POST['email'] ?? '');
            $password         = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $role             = 'user';
            $status           = 1;
            $ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) ?: 'unknown';
            $user_agent = substr($_SERVER['HTTP_USER_AGENT'] ?? 'unknown', 0, 255);

            // Kiểm tra thông tin đăng ký
            if (!$username || !$email || !$password || !$confirm_password) {
                $data['error'] = 'Vui lòng điền đầy đủ thông tin.';
            } elseif (strlen($username) < 6) {
                $data['error'] = 'Tên đăng nhập phải có ít nhất 6 ký tự.';
            } elseif (strlen($password) < 6) {
                $data['error'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
            } elseif ($password !== $confirm_password) {
                $data['error'] = 'Mật khẩu và xác nhận mật khẩu không khớp.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $data['error'] = 'Email không hợp lệ.';
            } elseif ($this->userModel->checkUsername($username) > 0) {
                $data['error'] = 'Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.';
            } elseif ($this->userModel->checkEmail($email) > 0) {
                $data['error'] = 'Email đã tồn tại. Vui lòng chọn email khác.';
            } else {
                // Tạo tài khoản, gọi hàm register trong model User
                if ($this->userModel->register($username, $email, $password, $role, $status, $ip, $user_agent)) {
                    $data['success'] = 'Đăng ký thành công! Vui lòng đăng nhập để tiếp tục.';
                    $data['redirect'] = '/auth/login';
                } else {
                    $data['error'] = 'Đăng ký thất bại. Vui lòng thử lại.';
                }
            }
        }
        // Hiển thị view login và truyền dữ liệu
        $this->view('site/auth/login', $data);
    }

    public function logout()
    {
        session_destroy();
        header("Location: /");
        exit;
    }
}
