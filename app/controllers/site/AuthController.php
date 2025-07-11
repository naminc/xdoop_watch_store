<?php

namespace controllers\site;

use core\BaseController;
use models\User;

class AuthController extends BaseController
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }

    public function login()
    {
        session_start();
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        $this->view('site/auth/login', $data);
    }
    public function register() {
        session_start();
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = $_POST['fullname'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';

            if (empty($fullname) || empty($email) || empty($password)) {
                $data['error'] = 'Vui lòng nhập đầy đủ thông tin.';
            } elseif ($password !== $confirm) {
                $data['error'] = 'Mật khẩu và xác nhận không khớp.';
            } else {
                $created = $this->userModel->create($email, $password, 'user');
                if ($created) {
                    $data['success'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
                    $data['redirect'] = '/auth/login';
                } else {
                    $data['error'] = 'Email đã tồn tại hoặc lỗi hệ thống.';
                }
            }
        }
        $this->view('site/auth/register', $data);
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: /");
    }
}
