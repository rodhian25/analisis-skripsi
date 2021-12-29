<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HasilIterasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                     => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'iterasi'                => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'total_medoids'          => ['type' => 'double', 'null' => true],
            'total_non_medoids'      => ['type' => 'double', 'null' => true],
            'selisih'                => ['type' => 'double', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('hasil_iterasi', true);
    }

    public function down()
    {
        $this->forge->dropTable('hasil_iterasi', true);
    }
}
