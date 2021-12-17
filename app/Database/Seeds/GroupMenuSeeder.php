<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GroupMenuSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                "group_id" => 1,
                "menu_id" => 1,
                "modul_id" => 1,
            ], [
                "group_id" => 1,
                "menu_id" => 2,
                "modul_id" => 1,
            ], [
                "group_id" => 1,
                "menu_id" => 3,
                "modul_id" => 1,
            ], [
                "group_id" => 1,
                "menu_id" => 4,
                "modul_id" => 1,
            ], [
                "group_id" => 1,
                "menu_id" => 5,
                "modul_id" => 1,
            ], [
                "group_id" => 2,
                "menu_id" => 1,
                "modul_id" => 1,
            ], [
                "group_id" => 2,
                "menu_id" => 2,
                "modul_id" => 1,
            ], [
                "group_id" => 2,
                "menu_id" => 3,
                "modul_id" => 1,
            ], [
                "group_id" => 2,
                "menu_id" => 5,
                "modul_id" => 1,
            ], [
                "group_id" => 3,
                "menu_id" => 5,
                "modul_id" => 1,
            ], [
                "group_id" => 1,
                "menu_id" => 6,
                "modul_id" => 1,
            ], [
                "group_id" => 1,
                "menu_id" => 7,
                "modul_id" => 1,
            ], [
                "group_id" => 2,
                "menu_id" => 6,
                "modul_id" => 1,
            ], [
                "group_id" => 2,
                "menu_id" => 7,
                "modul_id" => 1,
            ], [
                "group_id" => 3,
                "menu_id" => 6,
                "modul_id" => 1,
            ], [
                "group_id" => 3,
                "menu_id" => 7,
                "modul_id" => 1,
            ],
        ];

        $this->db->table("group_menu")->insertBatch($data);
    }
}
