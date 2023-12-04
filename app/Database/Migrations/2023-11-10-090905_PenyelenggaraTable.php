<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PenyelenggaraTable extends Migration
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
            'program_studi' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'program_studi_en' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'status_akreditasi' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'jenis_pendidikan' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'jenis_pendidikan_en' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'jenjang_pendidikan' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'jenjang_pendidikan_en' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'jenjang_pendidikan_sesuai_kkni' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'persyaratan_penerimaan' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'persyaratan_penerimaan_en' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'bahasa_pengantar_kuliah' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'bahasa_pengantar_kuliah_en' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'sistem_penilaian' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'lama_studi' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'lama_studi_en' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'jenis_jenjang_pendidikan_lanjutan' => [
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
        $this->forge->createTable('penyelenggara_program');
    }

    public function down()
    {
        $this->forge->dropTable('penyelenggara_program');
    }
}
