<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DataMesin extends Migration
{

    public function up()
    {
        $this->forge->addField([
            'data_id'          => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'device_id'          => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'jam'       => [
                'type'       => 'float',
                'default' => 0,
            ],
            'tanggal'       => [
                'type'       => 'date',
                'null' => true,
            ],
            'created_at datetime default current_timestamp',
        ]);
        $this->forge->addKey('data_id', true);
        $this->forge->addForeignKey('device_id', 'ms_device', 'device_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('data_mesin');
    }

    public function down()
    {
        $this->forge->dropTable('data_mesin');
    }
}
