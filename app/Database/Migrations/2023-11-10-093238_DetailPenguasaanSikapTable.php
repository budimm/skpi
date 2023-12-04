<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailPenguasaanSikapTable extends Migration
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
            'penguasaan_sikap_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'isi_penguasaan_sikap' => [
                'type' => 'TEXT',
            ],
            'isi_penguasaan_sikap_en' => [
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
        $this->forge->addForeignKey('penguasaan_sikap_id', 'penguasaan_sikap', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('detail_penguasaan_sikap');
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable('detail_penguasaan_sikap');
        $this->db->enableForeignKeyChecks();
    }
}
