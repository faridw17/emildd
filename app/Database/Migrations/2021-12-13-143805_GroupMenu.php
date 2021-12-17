<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GroupMenu extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'group_id'          => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'menu_id'          => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'modul_id'          => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addForeignKey('menu_id', 'ms_menu', 'menu_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('group_id', 'ms_group', 'group_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('modul_id', 'ms_modul', 'modul_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('group_menu');
    }

    public function down()
    {
        $this->forge->dropTable('group_menu');
    }
}
