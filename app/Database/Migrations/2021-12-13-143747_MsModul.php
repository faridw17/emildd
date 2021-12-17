<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MsModul extends Migration
{

    public function up()
    {
        $this->forge->addField([
            'modul_id'          => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'modul_kode'       => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'modul_nama'       => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'modul_status'       => [
                'type'       => 'boolean',
                'default' => 1,
            ],
        ]);
        $this->forge->addKey('modul_id', true);
        $this->forge->createTable('ms_modul');
    }

    public function down()
    {
        $this->forge->dropTable('ms_modul');
    }
}
