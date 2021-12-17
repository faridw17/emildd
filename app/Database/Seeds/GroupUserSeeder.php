<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GroupUserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                "group_id" => 1,
                "user_id" => 1,
                "view" => 1,
                "write" => 1,
            ], [
                "group_id" => 2,
                "user_id" => 1,
                "view" => 1,
                "write" => 1,
            ], [
                "group_id" => 2,
                "user_id" => 2,
                "view" => 1,
                "write" => 1,
            ], [
                "group_id" => 3,
                "user_id" => 3,
                "view" => 1,
                "write" => 1,
            ],
        ];

        $this->db->table("group_user")->insertBatch($data);
    }
}
