<?php

namespace App\Models;

use CodeIgniter\Model;

class MyModel extends Model
{
    public function get_sidebar($user_id, $modul_id, $parent_id = 0)
    {
        $sql = "SELECT
                    distinct mm.menu_id ,
                    mm.menu_nama ,
                    mm.menu_url ,
                    mm.menu_ikon ,
                    coalesce(child.total, 0) as total
                from
                    ms_menu mm
                inner join group_menu gm on
                    gm.menu_id = mm.menu_id
                inner join group_user gu on
                    gu.group_id = gm.group_id
                left join (
                    select
                        count(*) as total,
                        menu_parent_id
                    from
                        ms_menu
                    group by
                        menu_parent_id 
                    ) child on
                    child.menu_parent_id = mm.menu_id
                where
                    gu.user_id = $user_id
                    and mm.modul_id = $modul_id
                    and mm.menu_status = 1
                    and mm.menu_parent_id = $parent_id
                order by
                    mm.menu_kode";
        $result = $this->db->query($sql)->getResult();

        $res = "";

        foreach ($result as $key => $value) {
            if ($value->total <= 0 && $parent_id == 0) {
                $res .=
                    '<li class="nav-item">
                    <a class="nav-link" href="' . base_url() . '/' . $value->menu_url . '">
                        <i class="' . (!empty($value->menu_ikon) ? $value->menu_ikon : 'far fa-circle') . '"></i>
                        <span>' . $value->menu_nama . '</span>
                    </a>
                </li>';
            } else if ($value->total > 0 && $parent_id == 0) {
                $res .= '<li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menu_id' . $value->menu_id . '" aria-expanded="false" aria-controls="menu_id' . $value->menu_id . '">
                        <i class="' . (!empty($value->menu_ikon) ? $value->menu_ikon : 'far fa-circle') . '"></i>
                        <span>' . $value->menu_nama . '</span>
                    </a>
                    <div id="menu_id' . $value->menu_id . '" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
                        <div class="bg-white py-2 collapse-inner rounded">
                        ' . $this->get_sidebar($user_id, $modul_id, $value->menu_id) . '
                        </div>
                    </div>
                </li>';
            } else {
                $res .= '<a class="collapse-item" href="' . base_url() . '/' . $value->menu_url . '">' . $value->menu_nama . '</a>';
            }
        }

        return $res;
    }
}
