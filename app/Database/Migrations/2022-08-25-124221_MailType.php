<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MailType extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'kd_jenissurat' => ['type' => 'int', 'constraint' => 3, 'auto_increment' => true, 'unsigned' => true],
      'kode_surat' => ['type' => 'varchar', 'constraint' => 10],
      'nama_jenis' => ['type' => 'varchar', 'constraint' => 30],
      'created_at' => ['type' => 'datetime', 'null' => true],
      'updated_at' => ['type' => 'datetime', 'null' => true],
      'deleted_at' => ['type' => 'datetime', 'null' => true],
    ]);
    $this->forge->addPrimaryKey('kd_jenissurat');
    $this->forge->createTable('mail_type');
  }

  public function down()
  {
    $this->forge->dropTable('mail_type');
  }
}
