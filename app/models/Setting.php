<?php

namespace models;

use core\Model;

class Setting extends Model
{
    private $id;
    private $title;
    private $keyword;
    private $description;
    private $brand;
    private $domain;
    private $owner;
    private $email;
    private $phone;
    private $address;
    private $logo;
    private $icon;
    private $maintenance;
    private $created_at;
    private $updated_at;

    // Getter
    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getKeyword() { return $this->keyword; }
    public function getDescription() { return $this->description; }
    public function getBrand() { return $this->brand; }
    public function getDomain() { return $this->domain; }
    public function getOwner() { return $this->owner; }
    public function getEmail() { return $this->email; }
    public function getPhone() { return $this->phone; }
    public function getAddress() { return $this->address; }
    public function getLogo() { return $this->logo; }
    public function getIcon() { return $this->icon; }
    public function getMaintenance() { return $this->maintenance; }
    public function getCreatedAt() { return $this->created_at; }
    public function getUpdatedAt() { return $this->updated_at; }

    // Setter
    public function setId($id) { $this->id = $id; }
    public function setTitle($title) { $this->title = $title; }
    public function setKeyword($keyword) { $this->keyword = $keyword; }
    public function setDescription($description) { $this->description = $description; }
    public function setBrand($brand) { $this->brand = $brand; }
    public function setDomain($domain) { $this->domain = $domain; }
    public function setOwner($owner) { $this->owner = $owner; }
    public function setEmail($email) { $this->email = $email; }
    public function setPhone($phone) { $this->phone = $phone; }
    public function setAddress($address) { $this->address = $address; }
    public function setLogo($logo) { $this->logo = $logo; }
    public function setIcon($icon) { $this->icon = $icon; }
    public function setMaintenance($maintenance) { $this->maintenance = $maintenance; }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }
    public function setUpdatedAt($updated_at) { $this->updated_at = $updated_at; }

    // Lấy cấu hình
    public function getSetting()
    {
        $stmt = $this->db->prepare("SELECT * FROM settings LIMIT 1");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    // Cập nhật cấu hình
    public function updateSetting()
    {
        $stmt = $this->db->prepare("
        UPDATE settings 
        SET title = ?, keyword = ?, description = ?, domain = ?, owner = ?, brand = ?, email = ?, phone = ?, address = ?, logo = ?, icon = ?, maintenance = ?, updated_at = NOW() 
        WHERE id = ?
    ");
        $stmt->bind_param(
            "ssssssssssssi",
            $this->getTitle(),
            $this->getKeyword(),
            $this->getDescription(),
            $this->getDomain(),
            $this->getOwner(),
            $this->getBrand(),
            $this->getEmail(),
            $this->getPhone(),
            $this->getAddress(),
            $this->getLogo(),
            $this->getIcon(),
            $this->getMaintenance(),
            $this->getId()
        );
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
