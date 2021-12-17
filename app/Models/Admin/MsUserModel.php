<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class MsUserModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'ms_user';
    protected $primaryKey       = 'user_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "user_id",
        "user_name",
        "user_status",
        "is_superuser",
        "password",
        "user_fullname",
        "user_email",
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
                    ms_user mu
                left join (
                    select
                        user_id,
                        count(*) as total
                    from
                        group_user
                    group by
                        user_id) gu on
                    gu.user_id = mu.user_id
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
                    ms_user mu
                left join (
                    select
                        user_id,
                        count(*) as total
                    from
                        group_user
                    group by
                        user_id) gu on
                    gu.user_id = mu.user_id
                where
                    0 = 0
                    $where
                $order $limit";
        return $this->db->query($sql)->getResult();
    }

    public function get_akses($id)
    {
        $sql = "SELECT
                    mg.group_id ,
                    mg.group_nama ,
                    case
                        when gu.group_id is null then 0
                        else 1
                    end as akses
                from
                    ms_group mg
                left join group_user gu on
                    gu.group_id = mg.group_id
                    and gu.user_id = $id
                where
                    mg.group_status = 1
                    and mg.group_id != 1
                order by
                    mg.group_nama";
        $res = $this->db->query($sql)->getResult();
        return $res;
    }

    public function delete_akses($user_id)
    {
        $db = \Config\Database::connect();
        $group_user = $db->table('group_user');
        $result = $group_user->delete(['user_id' => $user_id]);
        if ($result) {
            $res = [
                'status' => true,
                'message' => "Berhasil Memperbarui Akses",
            ];
        } else {
            $res = [
                'status' => false,
                'message' => "Gagal Menghapus Akses",
            ];
        }

        return $res;
    }

    public function save_akses($data)
    {
        $db = \Config\Database::connect();
        $group_user = $db->table('group_user');
        $result = $group_user->insertBatch($data);
        if ($result) {
            $res = [
                'status' => true,
                'message' => "Berhasil Memperbarui Akses",
            ];
        } else {
            $res = [
                'status' => false,
                'message' => "Gagal Menambahkan Akses",
            ];
        }

        return $res;
    }
}
