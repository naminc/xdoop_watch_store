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
    private $stock;
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
    public function getStock() { return $this->stock; }
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
    public function setStock($stock) { $this->stock = $stock; }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }
    public function setUpdatedAt($updated_at) { $this->updated_at = $updated_at; }


    // Lấy tất cả sản phẩm
    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT products.*, categories.name as category_name, categories.slug as category_slug FROM products JOIN categories ON products.category_id = categories.id ORDER BY products.created_at DESC");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    // Lấy sản phẩm theo danh mục
    public function getProductByCategory()
    {
        $stmt = $this->db->prepare("SELECT products.*, categories.name as category_name, categories.slug as category_slug FROM products JOIN categories ON products.category_id = categories.id WHERE products.category_id = ?");
        $stmt->bind_param("i", $this->getCategoryId());
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    // Tạo sản phẩm
    public function create()
    {
        $stmt = $this->db->prepare("INSERT INTO products (name, description, image, price, category_id, stock, slug) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdiis", $this->getName(), $this->getDescription(), $this->getImage(), $this->getPrice(), $this->getCategoryId(), $this->getStock(), $this->getSlug());

        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    // Kiểm tra slug
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
    // Xóa sản phẩm
    public function delete()
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $this->getId());
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    // Lấy sản phẩm theo ID
    public function getProductById()
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $this->getId());
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    // Cập nhật sản phẩm
    public function update()
    {
        $stmt = $this->db->prepare("UPDATE products SET name = ?, description = ?, image = ?, price = ?, category_id = ?, stock = ?, slug = ? WHERE id = ?");
        $stmt->bind_param("sssdiisi", $this->getName(), $this->getDescription(), $this->getImage(), $this->getPrice(), $this->getCategoryId(), $this->getStock(), $this->getSlug(), $this->getId());
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    // Lấy sản phẩm theo slug
    public function getBySlug()
    {
        $stmt = $this->db->prepare("SELECT products.*, categories.name as category_name FROM products JOIN categories ON products.category_id = categories.id WHERE products.slug = ?");
        $stmt->bind_param("s", $this->getSlug());
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    // Đếm tất cả sản phẩm
    public function countAll()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM products");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }
    // Tìm kiếm sản phẩm
    public function searchProduct()
    {
        $like = '%' . $this->getName() . '%';
        $stmt = $this->db->prepare("SELECT products.*, categories.name as category_name FROM products JOIN categories ON products.category_id = categories.id WHERE products.name LIKE ? OR products.description LIKE ? OR products.slug LIKE ?");
        $stmt->bind_param("sss", $like, $like, $like);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    // Kiểm tra trạng thái sản phẩm
    public function checkStock()
    {
        $stmt = $this->db->prepare("SELECT stock FROM products WHERE id = ?");
        $stmt->bind_param("i", $this->getId());
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['stock'];
    }

    public function updateStock()
    {
        $stmt = $this->db->prepare("UPDATE products SET stock = ? WHERE id = ?");
        $stmt->bind_param("ii", $this->getStock(), $this->getId());
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
