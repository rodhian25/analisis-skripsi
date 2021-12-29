<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HasilProcessing extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_processing'     => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'item_produk'       => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'jumlah'            => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'harga'             => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'tahun'             => ['type' => 'int', 'constraint' => 5, 'null' => true],
        ]);

        $this->forge->addKey('id_processing', true);
        $this->forge->createTable('hasil_processing', true);
    }

    public function down()
    {
        $this->forge->dropTable('hasil_processing', true);
    }
}
