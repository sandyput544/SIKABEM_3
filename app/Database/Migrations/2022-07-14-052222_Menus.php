<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Menus extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'kd_menu' => ['type' => 'int', 'constraint' => 2, 'auto_increment' => true, 'unsigned' => true],
      'nama_menu' => ['type' => 'varchar', 'constraint' => 128],
      'url_menu' => ['type' => 'varchar', 'constraint' => 128],
      'ikon_menu' => ['type' => 'varchar', 'constraint' => 30],
      'menu_active' => ['type' => 'int', 'constraint' => 1],
      'created_at' => ['type' => 'datetime', 'null' => true],
      'updated_at' => ['type' => 'datetime', 'null' => true],
      'deleted_at' => ['type' => 'datetime', 'null' => true],
    ]);
    $this->forge->addPrimaryKey('kd_menu');
    $this->forge->createTable('menus');
  }

  public function down()
  {
    $this->forge->dropTable('menus');
  }
}
