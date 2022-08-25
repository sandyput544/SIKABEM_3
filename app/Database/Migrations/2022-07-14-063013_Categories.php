<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Categories extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'id' => ['type' => 'int', 'constraint' => 3, 'auto_increment' => true, 'unsigned' => true],
      'cat_name' => ['type' => 'varchar', 'constraint' => 128],
      'slug' => ['type' => 'varchar', 'constraint' => 128],
      'created_at' => ['type' => 'datetime', 'null' => true],
      'updated_at' => ['type' => 'datetime', 'null' => true],
      'deleted_at' => ['type' => 'datetime', 'null' => true],
    ]);
    $this->forge->addPrimaryKey('id');
    $this->forge->createTable('categories');
  }

  public function down()
  {
    $this->forge->dropTable('categories');
  }
}
