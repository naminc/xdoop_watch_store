<?php

namespace models;

use core\Model;

class Coupon extends Model
{
    private $id;
    private $code;
    private $discount_type;
    private $discount_value;
    private $expires_at;
    private $usage_limit;
    private $used_count;
    private $status;

    // Getter
    public function getId() { return $this->id; }
    public function getCode() { return $this->code; }
    public function getDiscountType() { return $this->discount_type; }
    public function getDiscountValue() { return $this->discount_value; }
    public function getExpiresAt() { return $this->expires_at; }
    public function getUsageLimit() { return $this->usage_limit; }
    public function getUsedCount() { return $this->used_count; }
    public function getStatus() { return $this->status; }

    // Setter
    public function setId($id) { $this->id = $id; }
    public function setCode($code) { $this->code = $code; }
    public function setDiscountType($discount_type) { $this->discount_type = $discount_type; }
    public function setDiscountValue($discount_value) { $this->discount_value = $discount_value; }
    public function setExpiresAt($expires_at) { $this->expires_at = $expires_at; }
    public function setUsageLimit($usage_limit) { $this->usage_limit = $usage_limit; }
    public function setUsedCount($used_count) { $this->used_count = $used_count; }
    public function setStatus($status) { $this->status = $status; }

    public function getByCode()
    {
        $stmt = $this->db->prepare("SELECT * FROM coupons WHERE code = ?");
        $stmt->bind_param("s", $this->getCode());
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function incrementUsage()
    {
        $stmt = $this->db->prepare("UPDATE coupons SET used_count = used_count + 1 WHERE code = ?");
        $stmt->bind_param("s", $this->getCode());
        $stmt->execute();
    }
    public function create()
    {
        $stmt = $this->db->prepare("INSERT INTO coupons (code, discount_type, discount_value, expires_at, usage_limit, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $this->getCode(), $this->getDiscountType(), $this->getDiscountValue(), $this->getExpiresAt(), $this->getUsageLimit(), $this->getStatus());
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    public function update()
    {
        $stmt = $this->db->prepare("UPDATE coupons SET code = ?, discount_type = ?, discount_value = ?, expires_at = ?, usage_limit = ?, status = ? WHERE id = ?");
        $stmt->bind_param("sssssii", $this->getCode(), $this->getDiscountType(), $this->getDiscountValue(), $this->getExpiresAt(), $this->getUsageLimit(), $this->getStatus(), $this->getId());
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    // Tắt mã giảm giá
    public function disable()
    {
        $stmt = $this->db->prepare("UPDATE coupons SET status = 0 WHERE id = ?");
        $stmt->bind_param("i", $this->getId());
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    // Bật mã giảm giá
    public function enable()
    {
        $stmt = $this->db->prepare("UPDATE coupons SET status = 1 WHERE id = ?");
        $stmt->bind_param("i", $this->getId());
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM coupons");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function getById()
    {
        $stmt = $this->db->prepare("SELECT * FROM coupons WHERE id = ?");
        $stmt->bind_param("i", $this->getId());
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function countAll()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM coupons");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['COUNT(*)'];
    }
}
