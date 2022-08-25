<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Positions extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'id' => ['type' => 'int', 'constraint' => '2', 'auto_increment' => true, 'unsigned' => true],
      'pos_name' => ['type' => 'varchar', 'constraint' => 128],
      'is_active' => ['type' => 'int', 'constraint' => 1],
      'created_at' => ['type' => 'datetime', 'null' => true],
      'updated_at' => ['type' => 'datetime', 'null' => true],
      'deleted_at' => ['type' => 'datetime', 'null' => true],
    ]);
    $this->forge->addPrimaryKey('id');
    $this->forge->createTable('positions');
  }

  public function down()
  {
    $this->forge->dropTable('positions');
  }
}
