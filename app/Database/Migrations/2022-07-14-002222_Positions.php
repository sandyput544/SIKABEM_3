<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Positions extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'kd_jabatan' => ['type' => 'int', 'constraint' => '2', 'auto_increment' => true, 'unsigned' => true],
      'nama_jbt' => ['type' => 'varchar', 'constraint' => 128],
      'singkatan_jbt' => ['type' => 'varchar', 'constraint' => 30],
      'jbt_active' => ['type' => 'int', 'constraint' => 1],
      'created_at' => ['type' => 'datetime', 'null' => true],
      'updated_at' => ['type' => 'datetime', 'null' => true],
      'deleted_at' => ['type' => 'datetime', 'null' => true],
    ]);
    $this->forge->addPrimaryKey('kd_jabatan');
    $this->forge->createTable('positions');
  }

  public function down()
  {
    $this->forge->dropTable('positions');
  }
}
