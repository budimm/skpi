<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailKemampuanBidangKhususTable extends Migration
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
            'kemampuan_bidang_khusus_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'isi_kemampuan_bidang_khusus' => [
                'type' => 'TEXT',
            ],
            'isi_kemampuan_bidang_khusus_en' => [
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
        // $this->forge->addConstraint('fk_d_kemampuan_bidang_khusus', [
        //     'type' => 'FOREIGN KEY',
        //     'fields' => ['kemampuan_bidang_khusus_id'],
        //     'references' => [
        //         'table' => 'kemampuan_bidang_khusus',
        //         'fields' => ['id'],
        //     ],
        //     'onUpdate' => 'CASCADE',
        //     'onDelete' => 'CASCADE'
        // ]);
        // $this->forge->addForeignKey('kemampuan_bidang_khusus_id', 'kemampuan_bidang_khusus', 'id', 'CASCADE', 'CASCADE', 'fk_d_kemampuan_bidang_khusus');
        $this->forge->createTable('detail_kemampuan_bidang_khusus');
        $this->db->query('ALTER TABLE detail_kemampuan_bidang_khusus ADD CONSTRAINT fk_d_kemampuan_bidang_khusus FOREIGN KEY (kemampuan_bidang_khusus_id) REFERENCES kemampuan_bidang_khusus(id) ON DELETE CASCADE ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable('detail_kemampuan_bidang_khusus');
        $this->db->enableForeignKeyChecks();
    }
}
