<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HasilKlaster extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_klaster'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'fk_id_processing'  => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'c'                 => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
        ]);


        $this->forge->addKey('id_klaster', true);
        $this->forge->addForeignKey('fk_id_processing','hasil_processing','id_processing', 'CASADE', 'CASADE');
        $this->forge->createTable('hasil_klaster', true);
    }

    public function down()
    {
        $this->forge->dropTable('hasil_klaster', true);
    }
}
