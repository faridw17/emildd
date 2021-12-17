<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Setting extends Migration
{

    public function up()
    {
        $this->forge->addField([
            'setting_id'          => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'setting_nama'       => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'setting_value'       => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'setting_ket'       => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'setting_status'       => [
                'type'       => 'boolean',
                'default' => 1,
            ],
        ]);
        $this->forge->addKey('setting_id', true);
        $this->forge->createTable('setting');
    }

    public function down()
    {
        $this->forge->dropTable('setting');
    }
}
