<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MsUser extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id'          => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_name'       => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'user_fullname'       => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'user_email'       => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'user_status'       => [
                'type'       => 'boolean',
                'default' => 1,
            ],
            'is_superuser'       => [
                'type'       => 'boolean',
                'default' => 0,
            ],
            'password' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('user_id', true);
        $this->forge->createTable('ms_user');
    }

    public function down()
    {
        $this->forge->dropTable('ms_user');
    }
}
