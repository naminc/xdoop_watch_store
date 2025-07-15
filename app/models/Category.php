<?php
namespace models;

use core\Model;

class Category extends Model
{
    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE status = 1");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function create($name, $slug, $description, $status)
    {
        $stmt = $this->db->prepare("INSERT INTO categories (name, slug, description, status, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
        $stmt->bind_param("ssss", $name, $slug, $description, $status);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    public function getByID($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function update($id, $name, $slug, $description, $status)
    {
        $stmt = $this->db->prepare("UPDATE categories SET name = ?, slug = ?, description = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $name, $slug, $description, $status, $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    public function findBySlug($slug)
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE slug = ?");
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}