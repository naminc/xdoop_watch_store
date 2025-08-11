<?php

namespace controllers\site;

use core\BaseController;
use models\User;

class AuthController extends BaseController
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function login()
    {
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
            $userM = new User(); 
            $userM->setUsername($_POST['username'] ?? '');
            $userM->setPassword($_POST['password'] ?? ''); 
            if (empty($userM->getUsername()) || empty($userM->getPassword())) { 
                $data['error'] = 'Tên đăng nhập và mật khẩu không được để trống.';
            } else if (strlen($userM->getUsername()) < 6) {
                $data['error'] = 'Tên đăng nhập phải có ít nhất 6 ký tự.';
            } else if (strlen($userM->getPassword()) < 6) {
                $data['error'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
            } else {
                $user = $userM->checkLogin(); 
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
            $userM = new User();
            $userM->setUsername($_POST['username'] ?? '');
            $userM->setFullname(''); 
            $userM->setPhone(''); 
            $userM->setEmail($_POST['email'] ?? '');
            $userM->setPassword($_POST['password'] ?? '');
            $confirm_password = $_POST['confirm_password'] ?? ''; 
            $userM->setRole('user');
            $userM->setStatus(1); 
            $userM->setIpAddress(filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) ?: 'unknown');
            $userM->setUserAgent(substr($_SERVER['HTTP_USER_AGENT'] ?? 'unknown', 0, 255));

            if (!$userM->getUsername() || !$userM->getEmail() || !$userM->getPassword() || !$confirm_password) {
                $data['error'] = 'Vui lòng điền đầy đủ thông tin.';
            } elseif (strlen($userM->getUsername()) < 6) { 
                $data['error'] = 'Tên đăng nhập phải có ít nhất 6 ký tự.';
            } elseif (strlen($userM->getPassword()) < 6) { 
                $data['error'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
            } elseif ($userM->getPassword() !== $confirm_password) { 
                $data['error'] = 'Mật khẩu và xác nhận mật khẩu không khớp.';
            } elseif (!filter_var($userM->getEmail(), FILTER_VALIDATE_EMAIL)) { 
                $data['error'] = 'Email không hợp lệ.';
            } elseif ($userM->checkUsername() > 0) { 
                $data['error'] = 'Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.';
            } elseif ($userM->checkEmail() > 0) { 
                $data['error'] = 'Email đã tồn tại. Vui lòng chọn email khác.';
            } else {
                if ($userM->register()) { 
                    $data['success'] = 'Đăng ký thành công! Vui lòng đăng nhập để tiếp tục.';
                    $data['redirect'] = '/auth/login';
                } else {
                    $data['error'] = 'Đăng ký thất bại. Vui lòng thử lại.';
                }
            }
        }
        $data['breadcrumbs'] = 'Đăng nhập - Đăng ký'; 
        $this->view('site/auth/login', $data); 
    }

    public function logout()
    {
        session_destroy(); 
        header("Location: /"); 
        exit;
    }
}