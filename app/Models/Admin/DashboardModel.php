<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    public function get_dashboard_mesin()
    {
        $sql = "SELECT
                    *
                from
                    ms_device md
                where
                    md.device_status = 1
                order by
                    device_kode";

        $res = $this->db->query($sql)->getResult();
        return $res;
    }

    public function get_label_x($limit = 10)
    {
        $sql = "SELECT
                    *
                from
                    (
                    select
                        distinct dm.tanggal
                    from
                        data_mesin dm
                    order by
                        dm.tanggal desc
                    limit $limit) label
                order by
                    tanggal asc";

        $result = $this->db->query($sql)->getResult();

        $res = [];

        foreach ($result as $key => $value) {
            $res[] = $value->tanggal;
        }
        return $res;
    }

    public function get_line_data($device_id, $tgl_pertama)
    {
        $tgl_pertama = date("Y-m-d", strtotime($tgl_pertama));
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
                        and dm.tanggal >= '$tgl_pertama'
                    group by
                        dm.tanggal
                    order by
                        dm.tanggal desc) label
                order by
                    label.tanggal asc";
        $res = $this->db->query($sql)->getResult();
        return $res;
    }

    public function get_bar_data($where = "")
    {
        # code...
    }
}
