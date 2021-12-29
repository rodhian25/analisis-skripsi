<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Data extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
      'no'               => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
      'tahun'            => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
      'receipt_number'   => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
      'staff'            => ['type' => 'varchar', 'constraint' => 25, 'null' => true],
      'tanggal'          => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
      'pukul'            => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
      'item_produk'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
      'jumlah'           => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
      'harga'            => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
      'created_at'       => ['type' => 'datetime', 'null' => true],
      'updated_at'       => ['type' => 'datetime', 'null' => true],
      'deleted_at'       => ['type' => 'datetime', 'null' => true],
    ]);

    $this->forge->addKey('id', true);
    $this->forge->addUniqueKey('no');

    $this->forge->createTable('data', true);
  }

  public function down()
  {
    $this->forge->dropTable('data', true);
  }
}
