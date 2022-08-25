<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Archives extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'id' => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
      'cat_id' => ['type' => 'int', 'constraint' => 3],
      'archive_name' => ['type' => 'varchar', 'constraint' => 128],
      'file_name' => ['type' => 'varchar', 'constraint' => 128],
      'file_ext' => ['type' => 'varchar', 'constraint' => 10],
      'file_size' => ['type' => 'varchar', 'constraint' => 30],
      'mime_type' => ['type' => 'varchar', 'constraint' => 255],
      'created_at' => ['type' => 'datetime', 'null' => true],
      'updated_at' => ['type' => 'datetime', 'null' => true],
      'deleted_at' => ['type' => 'datetime', 'null' => true],
    ]);
    $this->forge->addPrimaryKey('id');
    $this->forge->createTable('archives');
  }

  public function down()
  {
    $this->forge->dropTable('archives');
  }
}
