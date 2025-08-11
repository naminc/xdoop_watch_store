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
    public function getId()
    {
        return $this->id;
    }
    public function getUserId()
    {
        return $this->user_id;
    }
    public function getFullname()
    {
        return $this->fullname;
    }
    public function getPhone()
    {
        return $this->phone;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getAddress()
    {
        return $this->address;
    }
    public function getDistrict()
    {
        return $this->district;
    }
    public function getCity()
    {
        return $this->city;
    }
    public function getPostcode()
    {
        return $this->postcode;
    }
    public function getNote()
    {
        return $this->note;
    }
    public function getPaymentMethod()
    {
        return $this->payment_method;
    }
    public function getTotal()
    {
        return $this->total;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
    // Setter
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
    }
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setAddress($address)
    {
        $this->address = $address;
    }
    public function setDistrict($district)
    {
        $this->district = $district;
    }
    public function setCity($city)
    {
        $this->city = $city;
    }
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    }
    public function setNote($note)
    {
        $this->note = $note;
    }
    public function setPaymentMethod($payment_method)
    {
        $this->payment_method = $payment_method;
    }
    public function setTotal($total)
    {
        $this->total = $total;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }
    // Method
    // Lấy tất cả đơn hàng
    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT orders.*, users.username as user_name FROM orders LEFT JOIN users ON orders.user_id = users.id ORDER BY orders.created_at DESC");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    // Tạo đơn hàng
    public function createOrder()
    {
        $stmt = $this->db->prepare("INSERT INTO orders (user_id, fullname, phone, email, address, district, city, postcode, note, payment_method, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssssss", $this->getUserId(), $this->getFullname(), $this->getPhone(), $this->getEmail(), $this->getAddress(), $this->getDistrict(), $this->getCity(), $this->getPostcode(), $this->getNote(), $this->getPaymentMethod(), $this->getTotal());
        $stmt->execute();
        return $stmt->insert_id;
    }
    // Lấy đơn hàng theo ID
    public function getOrder()
    {
        $stmt = $this->db->prepare("SELECT orders.*, coupons.code as coupon_code, coupons.discount_type as coupon_discount_type, coupons.discount_value as coupon_discount_value FROM orders LEFT JOIN coupon_usages ON orders.id = coupon_usages.order_id LEFT JOIN coupons ON coupon_usages.coupon_id = coupons.id WHERE orders.id = ? ORDER BY orders.created_at DESC");
        $stmt->bind_param("i", $this->getId());
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    // Lấy đơn hàng theo ID người dùng
    public function getOrdersByUserId()
    {
        $stmt = $this->db->prepare("SELECT orders.*, coupons.code as coupon_code, coupons.discount_type as coupon_discount_type, coupons.discount_value as coupon_discount_value FROM orders LEFT JOIN coupon_usages ON orders.id = coupon_usages.order_id LEFT JOIN coupons ON coupon_usages.coupon_id = coupons.id WHERE orders.user_id = ? ORDER BY orders.created_at DESC");
        $stmt->bind_param("i", $this->getUserId());
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    // Cập nhật trạng thái đơn hàng
    public function updateStatus()
    {
        $stmt = $this->db->prepare("UPDATE orders SET status = ?, updated_at = NOW() WHERE id = ?");
        $stmt->bind_param("si", $this->getStatus(), $this->getId());
        return $stmt->execute();
    }
    // Đếm tất cả đơn hàng
    public function countAll()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM orders");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }
    // Đếm tất cả đơn hàng chờ xử lý
    public function countAllPending()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM orders WHERE status = 'pending'");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }
    // Đếm tất cả đơn hàng đang xử lý
    public function countAllProcessing()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM orders WHERE status = 'processing'");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }
    // Đếm tất cả đơn hàng đã hoàn thành
    public function countAllCompleted()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM orders WHERE status = 'completed'");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }
    // Đếm tất cả đơn hàng đã hủy
    public function countAllCancelled()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM orders WHERE status = 'cancelled'");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }
    // Đếm tất cả đơn hàng đang vận chuyển
    public function countAllShipping()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM orders WHERE status = 'shipping'");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }
    // Lấy tổng doanh thu theo ngày
    public function getTotalRevenueDay()
    {
        $stmt = $this->db->prepare("SELECT SUM(total) FROM orders WHERE DATE(created_at) = DATE(NOW()) AND status = 'completed'");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['SUM(total)'];
    }
    // Lấy tổng doanh thu theo tháng
    public function getTotalRevenueMonth()
    {
        $stmt = $this->db->prepare("SELECT SUM(total) FROM orders WHERE MONTH(created_at) = MONTH(NOW()) AND status = 'completed'");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['SUM(total)'];
    }
    // Lấy tổng doanh thu theo năm
    public function getTotalRevenueYear()
    {
        $stmt = $this->db->prepare("SELECT SUM(total) FROM orders WHERE YEAR(created_at) = YEAR(NOW()) AND status = 'completed'");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['SUM(total)'];
    }
    // Lấy tổng doanh thu tất cả
    public function getTotalRevenueAll()
    {
        $stmt = $this->db->prepare("SELECT SUM(total) FROM orders WHERE status = 'completed'");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['SUM(total)'];
    }
    // Lấy khách hàng mua nhiều nhất
    public function getBestCustomers()
    {
        $stmt = $this->db->prepare("SELECT users.id, users.username, users.fullname, COUNT(orders.id) as total_orders FROM users LEFT JOIN orders ON users.id = orders.user_id WHERE orders.status = 'completed' GROUP BY users.id ORDER BY total_orders DESC LIMIT 10");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    // Lấy tổng doanh thu theo ngày
    public function getRevenueByDate($date)
    {
        $stmt = $this->db->prepare("SELECT SUM(total) AS revenue FROM orders WHERE DATE(created_at) = ? AND status = 'completed'");
        $stmt->bind_param("s", $date);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    // Lấy tổng doanh thu theo tháng
    public function getRevenueByMonth($month)
    {
        $stmt = $this->db->prepare("SELECT SUM(total) AS revenue FROM orders WHERE DATE_FORMAT(created_at, '%Y-%m') = ? AND status = 'completed'");
        $stmt->bind_param("s", $month);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    // Lấy tổng doanh thu theo năm
    public function getRevenueByYear($year)
    {
        $stmt = $this->db->prepare("SELECT SUM(total) AS revenue FROM orders WHERE YEAR(created_at) = ? AND status = 'completed'");
        $stmt->bind_param("i", $year); // dùng kiểu int
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['revenue'] ?? 0; // luôn trả về số
    }
}
