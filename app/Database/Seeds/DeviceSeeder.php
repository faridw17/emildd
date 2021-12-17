<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DeviceSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'device_kode'    => "01",
                'device_nama'    => "Engine 1",
                'device_status'  => 1,
            ], [
                'device_kode'    => "02",
                'device_nama'    => "Engine 2",
                'device_status'  => 1,
            ],
        ];

        $this->db->table('ms_device')->insertBatch($data);
    }
}
