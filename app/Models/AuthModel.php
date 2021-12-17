<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    public function get_user_data($username)
    {
        $res = $this->db->query(
            "SELECT * FROM ms_user where user_name = '$username'"
        )->getRow();

        return $res;
    }

    public function get_setting()
    {
        $res = $this->db->query(
            "SELECT * FROM setting where setting_status = 1"
        )->getResult();

        return $res;
    }
}
