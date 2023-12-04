<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KemampuanBidangUmumTable extends Migration
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
        $this->forge->createTable('kemampuan_bidang_umum');
    }

    public function down()
    {
        $this->forge->dropTable('kemampuan_bidang_umum');
    }
}
