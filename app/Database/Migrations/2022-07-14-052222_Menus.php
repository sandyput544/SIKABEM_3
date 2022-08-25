<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Menus extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'id' => ['type' => 'int', 'constraint' => 2, 'auto_increment' => true, 'unsigned' => true],
      'menu_name' => ['type' => 'varchar', 'constraint' => 128],
      'menu_url' => ['type' => 'varchar', 'constraint' => 128],
      'menu_icon' => ['type' => 'varchar', 'constraint' => 20],
      'is_active' => ['type' => 'int', 'constraint' => 1],
      'created_at' => ['type' => 'datetime', 'null' => true],
      'updated_at' => ['type' => 'datetime', 'null' => true],
      'deleted_at' => ['type' => 'datetime', 'null' => true],
    ]);
    $this->forge->addPrimaryKey('id');
    $this->forge->createTable('menus');
  }

  public function down()
  {
    $this->forge->dropTable('menus');
  }
}
