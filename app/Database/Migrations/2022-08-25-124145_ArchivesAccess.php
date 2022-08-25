<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ArchivesAccess extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'kd_arsip' => ['type' => 'int', 'constraint' => 11],
      'kd_user' => ['type' => 'int', 'constraint' => 11],
      'tgl_akses' => ['type' => 'datetime'],
      'keterangan' => ['type' => 'varchar', 'constraint' => 128],
    ]);
    $this->forge->createTable('archives_access');
  }

  public function down()
  {
    $this->forge->dropTable('archives_access');
  }
}
