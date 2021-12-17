<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MsGroup extends Migration
{

    public function up()
    {
        $this->forge->addField([
            'group_id'          => [
                'type'           => 'INT',
                // 'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'group_kode'       => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'group_nama'       => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'group_status'       => [
                'type'       => 'boolean',
                'default' => 1,
            ],
            'group_ket' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('group_id', true);
        $this->forge->createTable('ms_group');
    }

    public function down()
    {
        $this->forge->dropTable('ms_group');
    }
}
