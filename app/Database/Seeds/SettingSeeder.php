<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'setting_nama' => "judul_website",
                'setting_value' => "Master",
                'setting_ket' => "Judul Website",
                'setting_status' => 1,
            ],
            [
                'setting_nama' => "nama_pt",
                'setting_value' => "PT Indonesia",
                'setting_ket' => "Nama PT",
                'setting_status' => 1,
            ],
        ];

        $this->db->table("setting")->insertBatch($data);
    }
}
