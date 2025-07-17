<?php
namespace models;

use core\Model;

class Product extends Model
{
    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT products.*, categories.name as category_name FROM products JOIN categories ON products.category_id = categories.id ORDER BY products.created_at DESC");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function getProductByCategory($categoryId)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE category_id = ?");
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function create($name, $description, $image, $price, $category_id, $status, $slug)
    {
        $stmt = $this->db->prepare("INSERT INTO products (name, description, image, price, category_id, status, slug) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdiis", $name, $description, $image, $price, $category_id, $status, $slug);
        
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    public function checkSlug($slug, $excludeId = null)
    {
        if ($excludeId) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM products WHERE slug = ? AND id != ?");
            $stmt->bind_param("si", $slug, $excludeId);
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM products WHERE slug = ?");
            $stmt->bind_param("s", $slug);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    public function getProductById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function update($id, $name, $description, $image, $price, $category_id, $status, $slug)
    {
        $stmt = $this->db->prepare("UPDATE products SET name = ?, description = ?, image = ?, price = ?, category_id = ?, status = ?, slug = ? WHERE id = ?");
        $stmt->bind_param("sssdiisi", $name, $description, $image, $price, $category_id, $status, $slug, $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}