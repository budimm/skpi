<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailPenguasaanPengetahuanTable extends Migration
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
            'penguasaan_pengetahuan_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'isi_penguasaan_pengetahuan' => [
                'type' => 'TEXT',
            ],
            'isi_penguasaan_pengetahuan_en' => [
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
        $this->forge->addForeignKey('penguasaan_pengetahuan_id', 'penguasaan_pengetahuan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('detail_penguasaan_pengetahuan');
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable('detail_penguasaan_pengetahuan');
        $this->db->enableForeignKeyChecks();
    }
}
