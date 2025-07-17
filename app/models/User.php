<?php

namespace models;

use core\Model;

class User extends Model
{
    public function checkLogin($username, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function checkUsername($username)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }

    public function checkEmail($email)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }

    public function register($username, $email, $password, $role, $status, $ip, $user_agent)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password, role, status, ip_address, user_agent, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
        $stmt->bind_param("sssssss", $username, $email, $hash, $role, $status, $ip, $user_agent);
        return $stmt->execute();
    }
    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function create($fullname, $username, $email, $password, $phone, $role, $status, $ip, $user_agent)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (fullname, username, email, password, phone, role, status, ip_address, user_agent, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
        $stmt->bind_param("sssssssss", $fullname, $username, $email, $hash, $phone, $role, $status, $ip, $user_agent);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    public function getByID($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function update($id, $fullname, $username, $email, $password, $phone, $role, $status, $ip, $user_agent)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE users SET fullname = ?, username = ?, email = ?, password = ?, phone = ?, role = ?, status = ?, ip_address = ?, user_agent = ? WHERE id = ?");
        $stmt->bind_param("sssssssssi", $fullname, $username, $email, $hash, $phone, $role, $status, $ip, $user_agent, $id);
        if (!$stmt->execute()) {
            return false;
        }
        return true;
    }
    public function updateWithoutPassword($id, $fullname, $username, $email, $phone, $role, $status, $ip, $user_agent)
    {
        $stmt = $this->db->prepare("UPDATE users SET fullname = ?, username = ?, email = ?, phone = ?, role = ?, status = ?, ip_address = ?, user_agent = ? WHERE id = ?");
        $stmt->bind_param("ssssssssi", $fullname, $username, $email, $phone, $role, $status, $ip, $user_agent, $id);
        if (!$stmt->execute()) {
            return false;
        }
        return true;
    }
    public function checkUsernameUpdate($username, $excludeId = null) {
        if ($excludeId) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE username = ? AND id != ?");
            $stmt->bind_param("si", $username, $excludeId);
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }
    public function checkEmailUpdate($email, $excludeId = null) {
        if ($excludeId) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = ? AND id != ?");
            $stmt->bind_param("si", $email, $excludeId);
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }
}