<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FakultasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'name_en' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'dekan' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('master_fakultas');
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->dropTable('master_fakultas');

        $this->db->enableForeignKeyChecks();
    }
}
