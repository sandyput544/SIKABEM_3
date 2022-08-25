<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Archives extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'kd_arsip' => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
      'kd_kategori' => ['type' => 'int', 'constraint' => 3],
      'nomor_arsip' => ['type' => 'varchar', 'constraint' => 15],
      'nama_arsip' => ['type' => 'varchar', 'constraint' => 128],
      'nama_file' => ['type' => 'varchar', 'constraint' => 128],
      'ukuran_file' => ['type' => 'varchar', 'constraint' => 15],
      'mime' => ['type' => 'varchar', 'constraint' => 255],
      'tgl_buat' => ['type' => 'date'],
      'nama_pembuat' => ['type' => 'varchar', 'constraint' => 128],
      'created_at' => ['type' => 'datetime', 'null' => true],
      'updated_at' => ['type' => 'datetime', 'null' => true],
      'deleted_at' => ['type' => 'datetime', 'null' => true],
    ]);
    $this->forge->addPrimaryKey('kd_arsip');
    $this->forge->createTable('archives');
  }

  public function down()
  {
    $this->forge->dropTable('archives');
  }
}
