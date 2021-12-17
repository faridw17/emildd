<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MsDevice extends Migration
{

    public function up()
    {
        $this->forge->addField([
            'device_id'          => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'device_kode'       => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'device_nama'       => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'device_status'       => [
                'type'       => 'boolean',
                'default' => 1,
            ],
        ]);
        $this->forge->addKey('device_id', true);
        $this->forge->createTable('ms_device');
    }

    public function down()
    {
        $this->forge->dropTable('ms_device');
    }
}
