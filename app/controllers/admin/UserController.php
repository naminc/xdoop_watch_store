<?php
namespace controllers\admin;

use core\BaseController;
use models\User;

class UserController extends BaseController
{
    public function index()
    {
        $this->view('admin/user/index');
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $hash = password_hash($password, PASSWORD_DEFAULT);
            header('Content-Type: application/json');
            echo json_encode(['username' => $username, 'email' => $email, 'password' => $hash], JSON_PRETTY_PRINT);
            exit;
        }
        $this->view('admin/user/create');
    }

    // // Form thêm user
    // public function create()
    // {
    //     $this->view('admin/user/create');
    // }

    // // Lưu user mới
    // public function store()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $username = $_POST['username'] ?? '';
    //         $email = $_POST['email'] ?? '';
    //         $password = $_POST['password'] ?? '';
    //         $role = $_POST['role'] ?? 'user';
    //         $status = $_POST['status'] ?? 1;

    //         if (empty($username) || empty($email) || empty($password)) {
    //             $error = "Vui lòng điền đầy đủ thông tin.";
    //             $this->view('admin/user/create', ['error' => $error]);
    //             return;
    //         }

    //         if ($this->userModel->create($username, $email, $password, $role, $status)) {
    //             header('Location: /admin/user');
    //             exit;
    //         } else {
    //             $error = "Thêm user thất bại.";
    //             $this->view('admin/user/create', ['error' => $error]);
    //         }
    //     }
    // }

    // // Form chỉnh sửa user
    // public function edit($id)
    // {
    //     $user = $this->userModel->findById($id);
    //     if (!$user) {
    //         header('Location: /admin/user');
    //         exit;
    //     }
    //     $this->view('admin/user/edit', ['user' => $user]);
    // }

    // // Cập nhật user
    // public function update($id)
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $username = $_POST['username'] ?? '';
    //         $email = $_POST['email'] ?? '';
    //         $role = $_POST['role'] ?? 'user';
    //         $status = $_POST['status'] ?? 1;

    //         if (empty($username) || empty($email)) {
    //             $error = "Vui lòng điền đầy đủ thông tin.";
    //             $user = $this->userModel->findById($id);
    //             $this->view('admin/user/edit', ['error' => $error, 'user' => $user]);
    //             return;
    //         }

    //         $this->userModel->update($id, $username, $email, $role, $status);
    //         header('Location: /admin/user');
    //         exit;
    //     }
    // }

    // // Xóa user
    // public function delete($id)
    // {
    //     $this->userModel->delete($id);
    //     header('Location: /admin/user');
    //     exit;
    // }
}
