<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CentroidAkhir extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'c'       => ['type' => 'varchar', 'constraint' => 11, 'null' => true],
            'jumlah'  => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'harga'   => ['type' => 'int', 'constraint' => 11, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('centroid_akhir', true);
    }

    public function down()
    {
        $this->forge->dropTable('centroid_akhir', true);
    }
}
