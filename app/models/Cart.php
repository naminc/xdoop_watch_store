<?php

namespace models;

use core\Model;

class Cart extends Model
{
    private $id;
    private $user_id;
    private $product_id;
    private $quantity;
    private $created_at;
    private $updated_at;

    // Getter
    public function getId() { return $this->id; }
    public function getUserId() { return $this->user_id; }
    public function getProductId() { return $this->product_id; }
    public function getQuantity() { return $this->quantity; }
    public function getCreatedAt() { return $this->created_at; }
    public function getUpdatedAt() { return $this->updated_at; }

    // Setter
    public function setId($id) { $this->id = $id; }
    public function setUserId($user_id) { $this->user_id = $user_id; }
    public function setProductId($product_id) { $this->product_id = $product_id; }
    public function setQuantity($quantity) { $this->quantity = $quantity; }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }
    public function setUpdatedAt($updated_at) { $this->updated_at = $updated_at; }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart()
    {
        $stmt = $this->db->prepare("SELECT id, quantity FROM cart_items WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $this->getUserId(), $this->getProductId());
        $stmt->execute();
        $result = $stmt->get_result();
        $item = $result->fetch_assoc();

        if ($item) {
            $newQuantity = $item['quantity'] + $this->getQuantity();
            $updateStmt = $this->db->prepare("UPDATE cart_items SET quantity = ?, updated_at = NOW() WHERE id = ?");
            $updateStmt->bind_param("ii", $newQuantity, $item['id']);
            return $updateStmt->execute();
        } else {
            $insertStmt = $this->db->prepare("INSERT INTO cart_items (user_id, product_id, quantity, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
            $insertStmt->bind_param("iii", $this->getUserId(), $this->getProductId(), $this->getQuantity());
            return $insertStmt->execute();
        }
    }

    // Lấy giỏ hàng
    public function getCart()
    {
        $stmt = $this->db->prepare("SELECT cart_items.*, products.name, products.price, products.image, products.slug FROM cart_items JOIN products ON cart_items.product_id = products.id WHERE cart_items.user_id = ?");
        $stmt->bind_param("i", $this->getUserId()); 
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Lấy số lượng sản phẩm trong giỏ hàng
    public function getCartCount()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM cart_items WHERE user_id = ?");
        $stmt->bind_param("i", $this->getUserId());
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }

    // Lấy tổng tiền của giỏ hàng
    public function getCartSubtotal()
    {
        $stmt = $this->db->prepare("SELECT SUM(products.price * cart_items.quantity) as subtotal FROM cart_items JOIN products ON cart_items.product_id = products.id WHERE cart_items.user_id = ?");
        $stmt->bind_param("i", $this->getUserId());
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['subtotal'] ?? 0;
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart()
    {
        $stmt = $this->db->prepare("DELETE FROM cart_items WHERE id = ?");
        $stmt->bind_param("i", $this->getId());
        return $stmt->execute();
    }

    // Xóa tất cả sản phẩm khỏi giỏ hàng
    public function clearCart()
    {
        $stmt = $this->db->prepare("DELETE FROM cart_items WHERE user_id = ?");
        $stmt->bind_param("i", $this->getUserId());
        return $stmt->execute();
    }

    public function checkQuantity()
    {
        $stmt = $this->db->prepare("SELECT quantity FROM cart_items WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $this->getUserId(), $this->getProductId());
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['quantity'];
    }
}