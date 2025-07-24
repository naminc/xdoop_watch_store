<?php
namespace models;

use core\Model;

class Category extends Model
{
    private $id;
    private $name;
    private $slug;
    private $description;
    private $status;
    private $created_at;
    private $updated_at;

    // Getter
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getSlug() { return $this->slug; }
    public function getDescription() { return $this->description; }
    public function getStatus() { return $this->status; }
    public function getCreatedAt() { return $this->created_at; }
    public function getUpdatedAt() { return $this->updated_at; }

    // Setter
    public function setId($id) { $this->id = $id; }
    public function setName($name) { $this->name = $name; }
    public function setSlug($slug) { $this->slug = $slug; }
    public function setDescription($description) { $this->description = $description; }
    public function setStatus($status) { $this->status = $status; }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }
    public function setUpdatedAt($updated_at) { $this->updated_at = $updated_at; }

    // Lấy tất cả danh mục
    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE status = 1");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    // Tạo danh mục
    public function create()
    {
        $stmt = $this->db->prepare("INSERT INTO categories (name, slug, description, status, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
        $stmt->bind_param("ssss", $this->getName(), $this->getSlug(), $this->getDescription(), $this->getStatus());
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    // Lấy danh mục theo ID
    public function getByID()
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->bind_param("i", $this->getId());
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    // Cập nhật danh mục
    public function update()
    {
        $stmt = $this->db->prepare("UPDATE categories SET name = ?, slug = ?, description = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $this->getName(), $this->getSlug(), $this->getDescription(), $this->getStatus(), $this->getId());
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    // Xóa danh mục
    public function delete()
    {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param("i", $this->getId());
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    // Tìm danh mục theo slug
    public function findBySlug()
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE slug = ?");
        $stmt->bind_param("s", $this->getSlug());
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    // Đếm tất cả danh mục
    public function countAll()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM categories");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }
}