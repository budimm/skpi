<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GelarTable extends Migration
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
            'prodi' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'fakultas' => [
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
        $this->forge->createTable('master_gelar');
    }

    public function down()
    {
        $this->forge->dropTable('master_gelar');
    }
}
