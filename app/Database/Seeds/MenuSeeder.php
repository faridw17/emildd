<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                "menu_kode" => "01",
                "menu_nama" => "Master Umum",
                "menu_status" => 1,
                "menu_url" => "#",
                "menu_ikon" => "",
                "menu_parent_id" => 0,
                "modul_id" => 1,
            ], [
                "menu_kode" => "01.01",
                "menu_nama" => "Master User",
                "menu_status" => 1,
                "menu_url" => "admin/msuser",
                "menu_ikon" => "",
                "menu_parent_id" => 1,
                "modul_id" => 1,
            ], [
                "menu_kode" => "01.02",
                "menu_nama" => "Master Group",
                "menu_status" => 1,
                "menu_url" => "admin/msgroup",
                "menu_ikon" => "",
                "menu_parent_id" => 1,
                "modul_id" => 1,
            ], [
                "menu_kode" => "99",
                "menu_nama" => "Master Menu",
                "menu_status" => 1,
                "menu_url" => "admin/msmenu",
                "menu_ikon" => "",
                "menu_parent_id" => 0,
                "modul_id" => 1,
            ], [
                "menu_kode" => "00",
                "menu_nama" => "Dashboard",
                "menu_status" => 1,
                "menu_url" => "admin/dashboard",
                "menu_ikon" => "",
                "menu_parent_id" => 0,
                "modul_id" => 1,
            ], [
                "menu_kode" => "02",
                "menu_nama" => "Master Data",
                "menu_status" => 1,
                "menu_url" => "#",
                "menu_ikon" => "fa fa-database",
                "menu_parent_id" => 0,
                "modul_id" => 1,
            ], [
                "menu_kode" => "02.01",
                "menu_nama" => "Master Device",
                "menu_status" => 1,
                "menu_url" => "admin/msdevice",
                "menu_ikon" => "",
                "menu_parent_id" => 6,
                "modul_id" => 1,
            ], [
                "menu_kode" => "03",
                "menu_nama" => "Mesin",
                "menu_status" => 1,
                "menu_url" => "#",
                "menu_ikon" => "",
                "menu_parent_id" => 0,
                "modul_id" => 1,
            ], [
                "menu_kode" => "03.01",
                "menu_nama" => "Mesin 1",
                "menu_status" => 1,
                "menu_url" => "admin/mesin/detail/1",
                "menu_ikon" => "",
                "menu_parent_id" => 8,
                "modul_id" => 1,
            ], [
                "menu_kode" => "03.02",
                "menu_nama" => "Mesin 2",
                "menu_status" => 1,
                "menu_url" => "admin/mesin/detail/2",
                "menu_ikon" => "",
                "menu_parent_id" => 8,
                "modul_id" => 1,
            ],
        ];

        $this->db->table('ms_menu')->insertBatch($data);
    }
}
