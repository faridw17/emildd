<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GroupUser extends Migration
{

    public function up()
    {
        $this->forge->addField([
            'group_id'          => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'user_id'          => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'view'       => [
                'type'       => 'boolean',
                'default' => 1,
            ],
            'write'       => [
                'type'       => 'boolean',
                'default' => 1,
            ],
        ]);
        $this->forge->addForeignKey('user_id', 'ms_user', 'user_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('group_id', 'ms_group', 'group_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('group_user');
    }

    public function down()
    {
        $this->forge->dropTable('group_user');
    }
}
