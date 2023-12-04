<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BagianDitjenDikti extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'prodi_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'text_bagian' => [
                'type' => 'TEXT',
            ],
            'text_bagian_en' => [
                'type' => 'TEXT',
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
        $this->forge->addForeignKey('prodi_id', 'master_prodi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('bagian_ditjen_dikti');
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable('bagian_ditjen_dikti');
        $this->db->enableForeignKeyChecks();
    }
}
