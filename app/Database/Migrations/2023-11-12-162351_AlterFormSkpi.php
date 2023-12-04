<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterFormSkpi extends Migration
{
    public function up()
    {
        $this->forge->addColumn('form_skpi', [
            'no_skpi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'after' => 'bagian_ditjen_dikti_id',
                'default' => null,
            ],
        ]);
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->dropColumn('form_skpi', 'no_skpi');

        $this->db->enableForeignKeyChecks();
    }
}
