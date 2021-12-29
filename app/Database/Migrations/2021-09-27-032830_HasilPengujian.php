<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HasilPengujian extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'     => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'c'       => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'si'      => ['type' => 'double', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('hasil_pengujian', true);
    }

    public function down()
    {
        $this->forge->dropTable('hasil_pengujian', true);
    }
}
