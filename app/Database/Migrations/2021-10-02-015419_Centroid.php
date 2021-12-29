<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Centroid extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'fk_id_processing' => ['type' => 'int', 'constraint' => 11, 'unsigned' => TRUE],
            'jumlah'  => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'harga'   => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'iterasi' => ['type' => 'int', 'constraint' => 11, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('fk_id_processing','hasil_processing','id_processing', 'CASADE', 'CASADE');
        $this->forge->createTable('centroid', true);
    }

    public function down()
    {
        $this->forge->dropTable('centroid', true);
    }
}
