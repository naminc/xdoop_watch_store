<?php

namespace models;

use core\Model;

class User extends Model
{
    private $id;
    private $fullname;
    private $username;
    private $email;
    private $password;
    private $phone;
    private $role;
    private $status;
    private $ip_address;
    private $user_agent;
    private $created_at;
    private $updated_at;

    // Getter
    public function getId() { return $this->id; }
    public function getFullname() { return $this->fullname; }
    public function getUsername() { return $this->username; }
    public function getPassword() { return $this->password; }
    public function getEmail() { return $this->email; }
    public function getPhone() { return $this->phone; }
    public function getRole() { return $this->role; }
    public function getStatus() { return $this->status; }
    public function getIpAddress() { return $this->ip_address; }
    public function getUserAgent() { return $this->user_agent; }
    public function getCreatedAt() { return $this->created_at; }
    public function getUpdatedAt() { return $this->updated_at; }

    // Setter
    public function setId($id) { $this->id = $id; }
    public function setFullname($fullname) { $this->fullname = $fullname; }
    public function setUsername($username) { $this->username = $username; }
    public function setPassword($password) { $this->password = $password; }
    public function setEmail($email) { $this->email = $email; }
    public function setPhone($phone) { $this->phone = $phone; }
    public function setRole($role) { $this->role = $role; }
    public function setStatus($status) { $this->status = $status; }
    public function setIpAddress($ip_address) { $this->ip_address = $ip_address; }
    public function setUserAgent($user_agent) { $this->user_agent = $user_agent; }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }
    public function setUpdatedAt($updated_at) { $this->updated_at = $updated_at; }


    // Kiểm tra đăng nhập
    public function checkLogin()
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $this->getUsername());
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        if ($user && password_verify($this->getPassword(), $user['password'])) {
            return $user;
        }
        return false;
    }

    // Kiểm tra username
    public function checkUsername()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->bind_param("s", $this->getUsername());
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }

    // Kiểm tra email
    public function checkEmail()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->bind_param("s", $this->getEmail());
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }

    // Đăng ký
    public function register()
    {
        $hash = password_hash($this->getPassword(), PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password, role, status, ip_address, user_agent, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
        $stmt->bind_param("sssssss", $this->getUsername(), $this->getEmail(), $hash, $this->getRole(), $this->getStatus(), $this->getIpAddress(), $this->getUserAgent());
        return $stmt->execute();
    }
    // Lất tất cả người dùng
    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    // Tạo người dùng
    public function create()
    {
        $hash = password_hash($this->getPassword(), PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (fullname, username, email, password, phone, role, status, ip_address, user_agent, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
        $stmt->bind_param("sssssssss", $this->getFullname(), $this->getUsername(), $this->getEmail(), $hash, $this->getPhone(), $this->getRole(), $this->getStatus(), $this->getIpAddress(), $this->getUserAgent());
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    // Xóa người dùng
    public function delete()
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $this->getId());
        return $stmt->execute();
    }
    // Lấy người dùng theo ID
    public function getByID()
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $this->getId());
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    // Cập nhật người dùng
    public function update()
    {
        $hash = password_hash($this->getPassword(), PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE users SET fullname = ?, username = ?, email = ?, password = ?, phone = ?, role = ?, status = ?, ip_address = ?, user_agent = ? WHERE id = ?");
        $stmt->bind_param("sssssssssi", $this->getFullname(), $this->getUsername(), $this->getEmail(), $hash, $this->getPhone(), $this->getRole(), $this->getStatus(), $this->getIpAddress(), $this->getUserAgent(), $this->getId());
        if (!$stmt->execute()) {
            return false;
        }
        return true;
    }
    // Cập nhật người dùng không cần mật khẩu
    public function updateWithoutPassword()
    {
        $stmt = $this->db->prepare("UPDATE users SET fullname = ?, username = ?, email = ?, phone = ?, role = ?, status = ?, ip_address = ?, user_agent = ? WHERE id = ?");
        $stmt->bind_param("ssssssssi", $this->getFullname(), $this->getUsername(), $this->getEmail(), $this->getPhone(), $this->getRole(), $this->getStatus(), $this->getIpAddress(), $this->getUserAgent(), $this->getId());
        if (!$stmt->execute()) {
            return false;
        }
        return true;
    }
    // Kiểm tra username cập nhật
    public function checkUsernameUpdate() {
        if ($this->getId()) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE username = ? AND id != ?");
            $stmt->bind_param("si", $this->getUsername(), $this->getId());
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
            $stmt->bind_param("s", $this->getUsername());
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }
    // Kiểm tra email cập nhật
    public function checkEmailUpdate() {
        if ($this->getId()) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = ? AND id != ?");
            $stmt->bind_param("si", $this->getEmail(), $this->getId());
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
            $stmt->bind_param("s", $this->getEmail());
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }

    // Cập nhật thông tin người dùng
    public function updateInfo()
    {
        $stmt = $this->db->prepare("UPDATE users SET fullname = ?, email = ?, phone = ?, updated_at = NOW() WHERE id = ?");
        $stmt->bind_param("sssi", $this->getFullname(), $this->getEmail(), $this->getPhone(), $this->getId());
        return $stmt->execute();
    }
    // Cập nhật mật khẩu người dùng
    public function updatePassword()
    {
        $hash = password_hash($this->getPassword(), PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE users SET password = ?, updated_at = NOW() WHERE id = ?");
        $stmt->bind_param("si", $hash, $this->getId());
        return $stmt->execute();
    }
    // Đếm tất cả người dùng
    public function countAll()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }
}