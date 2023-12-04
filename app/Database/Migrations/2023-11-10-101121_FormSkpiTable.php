<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FormSkpiTable extends Migration
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
            'penyelenggara_program_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'kemampuan_bidang_umum_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'kemampuan_bidang_khusus_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'penguasaan_pengetahuan_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'penguasaan_sikap_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'bagian_ditjen_dikti_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nim' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'ttl' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tanggal_masuk' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tanggal_lulus' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nomor_seri_ijazah' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'gelar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tugas_khusus_pengganti_kerja_praktek' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tugas_khusus_pengganti_kerja_praktek_en' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'pengalaman_organisasi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'pengalaman_organisasi_en' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tugas_akhir' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tugas_akhir_en' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tgl_pengesahan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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
        $this->forge->addForeignKey('penyelenggara_program_id', 'penyelenggara_program', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kemampuan_bidang_umum_id', 'kemampuan_bidang_umum', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kemampuan_bidang_khusus_id', 'kemampuan_bidang_khusus', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('penguasaan_pengetahuan_id', 'penguasaan_pengetahuan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('penguasaan_sikap_id', 'penguasaan_sikap', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('bagian_ditjen_dikti_id', 'bagian_ditjen_dikti', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('form_skpi');
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable('form_skpi');
        $this->db->enableForeignKeyChecks();
    }
}
