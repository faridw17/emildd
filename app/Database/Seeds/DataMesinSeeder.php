<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DataMesinSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'device_id'    => 1,
                'jam'    => 10.0,
                'created_at'  => '2021-12-19 00:56:17',
                'tanggal'  => '2021-12-19',
            ], [
                'device_id'    => 2,
                'jam'    => 12.0,
                'created_at'  => '2021-12-19 00:56:17',
                'tanggal'  => '2021-12-19',
            ], [
                'device_id'    => 2,
                'jam'    => 5.0,
                'created_at'  => '2021-12-19 00:56:17',
                'tanggal'  => '2021-12-18',
            ], [
                'device_id'    => 2,
                'jam'    => 10.0,
                'created_at'  => '2021-12-19 00:56:17',
                'tanggal'  => '2021-12-18',
            ],
        ];

        $this->db->table('ms_device')->insertBatch($data);
    }
}
