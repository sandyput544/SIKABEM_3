<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Categories extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'kd_kategori' => ['type' => 'int', 'constraint' => 3, 'auto_increment' => true, 'unsigned' => true],
      'nama_kat' => ['type' => 'varchar', 'constraint' => 128],
      'singkatan_kat' => ['type' => 'varchar', 'constraint' => 20],
      'slug' => ['type' => 'varchar', 'constraint' => 128],
      'created_at' => ['type' => 'datetime', 'null' => true],
      'updated_at' => ['type' => 'datetime', 'null' => true],
      'deleted_at' => ['type' => 'datetime', 'null' => true],
    ]);
    $this->forge->addPrimaryKey('kd_kategori');
    $this->forge->createTable('categories');
  }

  public function down()
  {
    $this->forge->dropTable('categories');
  }
}
