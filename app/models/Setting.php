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
        //
    }
}
