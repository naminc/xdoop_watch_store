<?php

namespace models;

use core\Model;

class Cart extends Model
{
    public function addToCart($user_id, $product_id, $quantity)
    {
        $stmt = $this->db->prepare("SELECT id, quantity FROM cart_items WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $item = $result->fetch_assoc();

        if ($item) {
            $newQuantity = $item['quantity'] + $quantity;
            $updateStmt = $this->db->prepare("UPDATE cart_items SET quantity = ?, updated_at = NOW() WHERE id = ?");
            $updateStmt->bind_param("ii", $newQuantity, $item['id']);
            return $updateStmt->execute();
        } else {
            $insertStmt = $this->db->prepare("INSERT INTO cart_items (user_id, product_id, quantity, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
            $insertStmt->bind_param("iii", $user_id, $product_id, $quantity);
            return $insertStmt->execute();
        }
    }

    public function getCart($user_id)
    {
        $stmt = $this->db->prepare("SELECT cart_items.*, products.name, products.price, products.image, products.slug FROM cart_items JOIN products ON cart_items.product_id = products.id WHERE cart_items.user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getCartCount($user_id)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM cart_items WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }

    public function getCartSubtotal($user_id)
    {
        $stmt = $this->db->prepare("SELECT SUM(products.price * cart_items.quantity) as subtotal FROM cart_items JOIN products ON cart_items.product_id = products.id WHERE cart_items.user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['subtotal'] ?? 0;
    }

    public function removeFromCart($id)
    {
        $stmt = $this->db->prepare("DELETE FROM cart_items WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function clearCart($user_id)
    {
        $stmt = $this->db->prepare("DELETE FROM cart_items WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }
}