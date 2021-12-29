<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CentroidTemp extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment'    => true],
            'jenis'             => ['type' => 'varchar', 'constraint' => 25, 'null' => true],
            'iterasi'           => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'c'                 => ['type' => 'varchar', 'constraint' => 5, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('centroid_temp', true);
    }

    public function down()
    {
        $this->forge->dropTable('centroid_temp', true);
    }
}
