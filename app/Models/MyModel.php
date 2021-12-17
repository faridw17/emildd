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
                    '<a class="nav-link" href="' . base_url() . '/' . $value->menu_url . '">
                        <div class="sb-nav-link-icon"><i class="' . (!empty($value->menu_ikon) ? $value->menu_ikon : 'far fa-circle') . '"></i></div>
                        ' . $value->menu_nama . '
                    </a>';
            } else if ($value->total > 0 && $parent_id == 0) {
                $res .=
                    '<a class="nav-link collapsed" href="' . base_url() . '/' . $value->menu_url . '" data-bs-toggle="collapse" data-bs-target="#collapseLayouts' . $value->menu_id . '" aria-expanded="false" aria-controls="collapseLayouts' . $value->menu_id . '">
                        <div class="sb-nav-link-icon"><i class="' . (!empty($value->menu_ikon) ? $value->menu_ikon : 'far fa-circle') . '"></i></div>
                        ' . $value->menu_nama . '
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts' . $value->menu_id . '" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">';
                $res .= $this->get_sidebar($user_id, $modul_id, $value->menu_id);
                $res .= "</nav>
                </div>";
            } else {
                $res .= '<a class="nav-link" href="' . base_url() . '/' . $value->menu_url . '">' . $value->menu_nama . '</a>';
            }
        }

        return $res;
    }
}
