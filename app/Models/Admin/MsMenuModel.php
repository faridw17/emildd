<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class MsMenuModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'ms_menu';
    protected $primaryKey       = 'menu_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'menu_id',
        'menu_kode',
        'menu_nama',
        'menu_url',
        'menu_ikon',
        'menu_parent_id',
        'menu_parent_kode',
        'menu_status',
        'modul_id',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function get_total($where)
    {
        $sql = "SELECT
                    count(*) as total
                from
                    ms_menu mm
                left join ms_menu parent on
                    parent.menu_id = mm.menu_parent_id
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
                    0 = 0
                    $where";
        return $this->db->query($sql)->getRow()->total;
    }

    public function get_data($limit, $where, $order, $columns)
    {
        $slc = implode(',', $columns);
        $sql = "SELECT
                    $slc
                from
                    ms_menu mm
                left join ms_menu parent on
                    parent.menu_id = mm.menu_parent_id
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
                    0 = 0
                    $where
                $order $limit";
        return $this->db->query($sql)->getResult();
    }

    public function proses_check($where = '')
    {
        $sql = "SELECT count(*) as total from ms_menu where 0 = 0 $where ";

        $tot = $this->db->query($sql)->getRow()->total;

        return $tot;
    }

    public function get_modul()
    {
        $sql = "SELECT 
                    *
                from
                    ms_modul
                where
                    modul_status = 1
                order by
                    modul_kode";

        $res = $this->db->query($sql)->getResult();

        return $res;
    }
}
