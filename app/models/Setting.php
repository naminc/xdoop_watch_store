<?php
namespace models;

use core\Model;

class Setting extends Model
{
    public function getSetting()
    {
        $result = $this->db->query("SELECT * FROM settings LIMIT 1");
        return $result->fetch_assoc();
    }
    public function updateSetting($data)
    {
        $stmt = $this->db->prepare("UPDATE settings SET title = ?, keyword = ?, description = ?, domain = ?, brand = ?, email = ?, phone = ?, address = ?, logo = ?, icon = ?, maintenance = ?, created_at = NOW(), updated_at = NOW() WHERE id = 1");
        $stmt->bind_param("sssssssssss", $data['title'], $data['keyword'], $data['description'], $data['domain'], $data['brand'], $data['email'], $data['phone'], $data['address'], $data['logo'], $data['icon'], $data['maintenance']);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}