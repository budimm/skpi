<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterMasterFakultas extends Migration
{
    public function up()
    {
        $this->forge->addColumn('master_fakultas', [
            'dekan_nidn' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'after' => 'dekan',
                'default' => null,
            ],
        ]);
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->dropColumn('master_fakultas', 'dekan_nidn');

        $this->db->enableForeignKeyChecks();
    }
}
