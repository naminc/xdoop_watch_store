<?php
namespace models;

use core\Model;

class OrderItem extends Model
{
    private $id;
    private $order_id;
    private $product_id;
    private $quantity;
    private $price;
    private $created_at;
    private $updated_at;

    // Getter
    public function getId() { return $this->id; }
    public function getOrderId() { return $this->order_id; }
    public function getProductId() { return $this->product_id; }
    public function getQuantity() { return $this->quantity; }
    public function getPrice() { return $this->price; }
    public function getCreatedAt() { return $this->created_at; }
    public function getUpdatedAt() { return $this->updated_at; }
    // Setter
    public function setId($id) { $this->id = $id; }
    public function setOrderId($order_id) { $this->order_id = $order_id; }
    public function setProductId($product_id) { $this->product_id = $product_id; }
    public function setQuantity($quantity) { $this->quantity = $quantity; }
    public function setPrice($price) { $this->price = $price; }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }
    public function setUpdatedAt($updated_at) { $this->updated_at = $updated_at; }
    
    // Method
    public function getOrderItemsByOrderId()
    {
        $stmt = $this->db->prepare("SELECT order_items.*, products.name, products.image, products.slug FROM order_items JOIN products ON order_items.product_id = products.id WHERE order_id = ?");
        $stmt->bind_param("i", $this->getOrderId());
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function addOrderItem()
    {
        $stmt = $this->db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $this->getOrderId(), $this->getProductId(), $this->getQuantity(), $this->getPrice());
        $stmt->execute();
    }
} 