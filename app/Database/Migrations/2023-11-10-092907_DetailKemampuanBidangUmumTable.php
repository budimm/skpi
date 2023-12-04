<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailKemampuanBidangUmumTable extends Migration
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
            'kemampuan_bidang_umum_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'isi_kemampuan_bidang_umum' => [
                'type' => 'TEXT',
            ],
            'isi_kemampuan_bidang_umum_en' => [
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
        $this->forge->addForeignKey('kemampuan_bidang_umum_id', 'kemampuan_bidang_umum', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('detail_kemampuan_bidang_umum');
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable('detail_kemampuan_bidang_umum');
        $this->db->enableForeignKeyChecks();
    }
}
