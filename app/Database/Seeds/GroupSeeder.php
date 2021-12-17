<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GroupSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'group_kode'    => "01",
                'group_nama'    => "Admin Vendor",
                'group_status'  => 1,
                'group_ket'     => "",
            ], [
                'group_kode'    => "02",
                'group_nama'    => "Administrator",
                'group_status'  => 1,
                'group_ket'     => "",
            ], [
                'group_kode'    => "03",
                'group_nama'    => "User",
                'group_status'  => 1,
                'group_ket'     => "",
            ],
        ];

        $this->db->table('ms_group')->insertBatch($data);
    }
}
