<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ModulSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                "modul_kode" => "01",
                "modul_nama" => "Administrator",
                "modul_status" => 1,
            ],
        ];

        $this->db->table("ms_modul")->insertBatch($data);
    }
}
