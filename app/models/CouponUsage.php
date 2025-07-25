<?php

namespace models;

use core\Model;

class CouponUsage extends Model
{
    private $id;
    private $coupon_id;
    private $user_id;
    private $order_id;
    private $used_at;

    public function getId() { return $this->id; }
    public function getCouponId() { return $this->coupon_id; }
    public function getUserId() { return $this->user_id; }
    public function getOrderId() { return $this->order_id; }
    public function getUsedAt() { return $this->used_at; }

    public function setId($id) { $this->id = $id; }
    public function setCouponId($coupon_id) { $this->coupon_id = $coupon_id; }
    public function setUserId($user_id) { $this->user_id = $user_id; }
    public function setOrderId($order_id) { $this->order_id = $order_id; }
    public function setUsedAt($used_at) { $this->used_at = $used_at; }

    public function create()
    {
        $stmt = $this->db->prepare("INSERT INTO coupon_usages (coupon_id, user_id, order_id, used_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iis", $this->getCouponId(), $this->getUserId(), $this->getOrderId());
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function getByCouponId()
    {
        $stmt = $this->db->prepare("SELECT * FROM coupon_usages WHERE coupon_id = ?");
        $stmt->bind_param("i", $this->getCouponId());
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function checkUsed()
    {
        $stmt = $this->db->prepare("SELECT * FROM coupon_usages WHERE coupon_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $this->getCouponId(), $this->getUserId());
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
