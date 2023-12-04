<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'fakultas_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'after' => 'username',
                'null' => true,
                'default' => null
            ],
            'prodi_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'after' => 'fakultas_id',
                'null' => true,
                'default' => null
            ],
            'avatar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'after' => 'prodi_id',
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'after' => 'avatar',
            ],
        ]);
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->dropColumn('users', 'fakultas_id');
        $this->forge->dropColumn('users', 'prodi_id');

        $this->db->enableForeignKeyChecks();
    }
}
