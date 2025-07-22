<?php

namespace models;

use core\Model;

class Product extends Model
{
    private $id;
    private $name;
    private $slug;
    private $description;
    private $image;
    private $price;
    private $category_id;
    private $status;
    private $created_at;
    private $updated_at;

    // Getter
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getSlug() { return $this->slug; }
    public function getDescription() { return $this->description; }
    public function getImage() { return $this->image; }
    public function getPrice() { return $this->price; }
    public function getCategoryId() { return $this->category_id; }
    public function getStatus() { return $this->status; }
    public function getCreatedAt() { return $this->created_at; }
    public function getUpdatedAt() { return $this->updated_at; }
    
    // Setter
    public function setId($id) { $this->id = $id; }
    public function setName($name) { $this->name = $name; }
    public function setSlug($slug) { $this->slug = $slug; }
    public function setDescription($description) { $this->description = $description; }
    public function setImage($image) { $this->image = $image; }
    public function setPrice($price) { $this->price = $price; }
    public function setCategoryId($category_id) { $this->category_id = $category_id; }
    public function setStatus($status) { $this->status = $status; }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }
    public function setUpdatedAt($updated_at) { $this->updated_at = $updated_at; }


    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT products.*, categories.name as category_name FROM products JOIN categories ON products.category_id = categories.id ORDER BY products.created_at DESC");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function getProductByCategory()
    {
        $stmt = $this->db->prepare("SELECT products.*, categories.name as category_name, categories.slug as category_slug FROM products JOIN categories ON products.category_id = categories.id WHERE products.category_id = ?");
        $stmt->bind_param("i", $this->getCategoryId());
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function create()
    {
        $stmt = $this->db->prepare("INSERT INTO products (name, description, image, price, category_id, status, slug) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdiis", $this->getName(), $this->getDescription(), $this->getImage(), $this->getPrice(), $this->getCategoryId(), $this->getStatus(), $this->getSlug());

        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    public function checkSlug()
    {
        if ($this->getId()) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM products WHERE slug = ? AND id != ?");
            $stmt->bind_param("si", $this->getSlug(), $this->getId());
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM products WHERE slug = ?");
            $stmt->bind_param("s", $this->getSlug());
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }
    public function delete()
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $this->getId());
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    public function getProductById()
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $this->getId());
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function update()
    {
        $stmt = $this->db->prepare("UPDATE products SET name = ?, description = ?, image = ?, price = ?, category_id = ?, status = ?, slug = ? WHERE id = ?");
        $stmt->bind_param("sssdiisi", $this->getName(), $this->getDescription(), $this->getImage(), $this->getPrice(), $this->getCategoryId(), $this->getStatus(), $this->getSlug(), $this->getId());
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    public function getBySlug()
    {
        $stmt = $this->db->prepare("SELECT products.*, categories.name as category_name FROM products JOIN categories ON products.category_id = categories.id WHERE products.slug = ?");
        $stmt->bind_param("s", $this->getSlug());
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function countAll()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM products");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }
    public function searchProduct()
    {
        $like = '%' . $this->getName() . '%';
        $stmt = $this->db->prepare("SELECT * FROM products WHERE name LIKE ? OR description LIKE ? OR slug LIKE ?");
        $stmt->bind_param("sss", $like, $like, $like);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
