<?php
namespace models;

use core\Model;

class Order extends Model
{
    private $id;
    private $user_id;
    private $fullname;
    private $phone;
    private $email;
    private $address;
    private $district;
    private $city;
    private $postcode;
    private $note;
    private $payment_method;
    private $total;
    private $status;
    private $created_at;
    private $updated_at;    

    // Getter
    public function getId() { return $this->id; }
    public function getUserId() { return $this->user_id; }
    public function getFullname() { return $this->fullname; }
    public function getPhone() { return $this->phone; }
    public function getEmail() { return $this->email; }
    public function getAddress() { return $this->address; }
    public function getDistrict() { return $this->district; }
    public function getCity() { return $this->city; }
    public function getPostcode() { return $this->postcode; }
    public function getNote() { return $this->note; }
    public function getPaymentMethod() { return $this->payment_method; }
    public function getTotal() { return $this->total; }
    public function getStatus() { return $this->status; }
    public function getCreatedAt() { return $this->created_at; }
    public function getUpdatedAt() { return $this->updated_at; }
    // Setter
    public function setId($id) { $this->id = $id; }
    public function setUserId($user_id) { $this->user_id = $user_id; }
    public function setFullname($fullname) { $this->fullname = $fullname; }
    public function setPhone($phone) { $this->phone = $phone; }
    public function setEmail($email) { $this->email = $email; }
    public function setAddress($address) { $this->address = $address; }
    public function setDistrict($district) { $this->district = $district; }
    public function setCity($city) { $this->city = $city; }
    public function setPostcode($postcode) { $this->postcode = $postcode; }
    public function setNote($note) { $this->note = $note; }
    public function setPaymentMethod($payment_method) { $this->payment_method = $payment_method; }
    public function setTotal($total) { $this->total = $total; }
    public function setStatus($status) { $this->status = $status; }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }
    public function setUpdatedAt($updated_at) { $this->updated_at = $updated_at; }
    // Method
    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT orders.*, users.username as user_name FROM orders JOIN users ON orders.user_id = users.id ORDER BY orders.created_at DESC");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function createOrder()
    {
        $stmt = $this->db->prepare("INSERT INTO orders (user_id, fullname, phone, email, address, district, city, postcode, note, payment_method, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssssss", $this->getUserId(), $this->getFullname(), $this->getPhone(), $this->getEmail(), $this->getAddress(), $this->getDistrict(), $this->getCity(), $this->getPostcode(), $this->getNote(), $this->getPaymentMethod(), $this->getTotal());
        $stmt->execute();
        return $stmt->insert_id;
    }
    public function getOrder()
    {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->bind_param("i", $this->getId());
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function getOrdersByUserId()
    {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE user_id = ?");
        $stmt->bind_param("i", $this->getUserId());
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function updateStatus()
    {
        $stmt = $this->db->prepare("UPDATE orders SET status = ?, updated_at = NOW() WHERE id = ?");
        $stmt->bind_param("si", $this->getStatus(), $this->getId());
        return $stmt->execute();
    }
    public function countAll()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM orders");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }
    public function countAllPending()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM orders WHERE status = 'pending'");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }
    public function countAllProcessing()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM orders WHERE status = 'processing'");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }
    public function countAllCompleted()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM orders WHERE status = 'completed'");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }
    public function countAllCancelled()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM orders WHERE status = 'cancelled'");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }
    public function countAllShipping()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM orders WHERE status = 'shipping'");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }
    public function getTotalRevenueDay()
    {
        $stmt = $this->db->prepare("SELECT SUM(total) FROM orders WHERE DATE(created_at) = DATE(NOW())");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['SUM(total)'];
    }
    public function getTotalRevenueMonth()
    {
        $stmt = $this->db->prepare("SELECT SUM(total) FROM orders WHERE MONTH(created_at) = MONTH(NOW())");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['SUM(total)'];
    }
    public function getTotalRevenueYear()
    {
        $stmt = $this->db->prepare("SELECT SUM(total) FROM orders WHERE YEAR(created_at) = YEAR(NOW())");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['SUM(total)'];
    }
    public function getTotalRevenueAll()
    {
        $stmt = $this->db->prepare("SELECT SUM(total) FROM orders");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['SUM(total)'];
    }
}