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

    public function getAll()
    {
        $result = $this->db->query("SELECT id, username, role FROM users");
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        return $users;
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT id, username, role FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function create($username, $password, $role)
    {
        $hash = hash('sha256', $password);
        $stmt = $this->db->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hash, $role);
        return $stmt->execute();
    }

    public function update($id, $username, $role)
    {
        $stmt = $this->db->prepare("UPDATE users SET username = ?, role = ? WHERE id = ?");
        $stmt->bind_param("ssi", $username, $role, $id);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
