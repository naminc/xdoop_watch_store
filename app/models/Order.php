<?php
namespace models;

use core\Model;

class Order extends Model
{
    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM orders");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function createOrder($data)
    {
        $stmt = $this->db->prepare("INSERT INTO orders (user_id, fullname, phone, email, address, district, city, postcode, note, payment_method, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssssss", $data['user_id'], $data['fullname'], $data['phone'], $data['email'], $data['address'], $data['district'], $data['city'], $data['postcode'], $data['note'], $data['payment_method'], $data['total']);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function addOrderItem($data)
    {
        $stmt = $this->db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $data['order_id'], $data['product_id'], $data['quantity'], $data['price']);
        $stmt->execute();
    }

    public function getOrder($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getOrderItems($orderId)
    {
        $stmt = $this->db->prepare("SELECT order_items.*, products.name, products.image, products.slug FROM order_items JOIN products ON order_items.product_id = products.id WHERE order_id = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function updateOrder($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE orders SET fullname = ?, phone = ?, email = ?, address = ?, district = ?, city = ?, postcode = ?, note = ?, payment_method = ?, total = ? WHERE id = ?");
        $stmt->bind_param("ssssssssss", $data['fullname'], $data['phone'], $data['email'], $data['address'], $data['district'], $data['city'], $data['postcode'], $data['note'], $data['payment_method'], $data['total'], $id);
        return $stmt->execute();
    }

    public function deleteOrder($id)
    {
        $stmt = $this->db->prepare("DELETE FROM orders WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function deleteOrderItem($id)
    {
        $stmt = $this->db->prepare("DELETE FROM order_items WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    public function getOrdersByUserId($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}