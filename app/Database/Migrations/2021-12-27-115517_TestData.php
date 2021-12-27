<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TestData extends Migration
{

    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'data'       => [
                'type'       => 'text',
                'null' => true,
            ],
            'created_at datetime default current_timestamp',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('test_data');
    }

    public function down()
    {
        $this->forge->dropTable('test_data');
    }
}
