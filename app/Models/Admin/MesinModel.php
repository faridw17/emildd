<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class MesinModel extends Model
{
    public function get_data_device($device_id)
    {
        $sql = "SELECT * from ms_device where device_id = $device_id";

        $res = $this->db->query($sql)->getRow();
        return $res;
    }

    public function get_line_data($device_id, $limit = 10)
    {
        $sql = "SELECT
                    *
                from
                    (
                    select
                        date_format(dm.tanggal, '%d-%m-%Y') tanggal,
                        sum(dm.jam) jam
                    from
                        data_mesin dm
                    where
                        dm.device_id = $device_id
                    group by
                        dm.tanggal
                    order by
                        dm.tanggal desc
                    limit $limit) label
                order by
                    tanggal asc";
        $res = $this->db->query($sql)->getResult();
        return $res;
    }
}
