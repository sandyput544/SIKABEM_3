<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'kd_user' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
      'kd_jabatan' => ['type' => 'int', 'constraint' => 2],
      'nama_user' => ['type' => 'varchar', 'constraint' => 128],
      'tmp_lahir' => ['type' => 'varchar', 'constraint' => 80, 'null' => true],
      'tgl_lahir' => ['type' => 'date', 'null' => true],
      'jk' => ['type' => 'enum', 'constraint' => ['Pria', 'Wanita']],
      'agama' => ['type' => 'enum', 'constraint' => ['Buddha', 'Hindhu', 'Islam', 'Katholik', 'Konghucu', 'Kristen Protestan']],
      'no_hp' => ['type' => 'varchar', 'constraint' => 13],
      'alamat' => ['type' => 'text', 'null' => true],
      'email' => ['type' => 'varchar', 'constraint' => 128],
      'password' => ['type' => 'varchar', 'constraint' => 128],
      'password_hash' => ['type' => 'varchar', 'constraint' => 128],
      'foto' => ['type' => 'varchar', 'constraint' => 128, 'null' => true],
      'user_active' => ['type' => 'int', 'constraint' => 1],
      'is_login' => ['type' => 'int', 'constraint' => 1],
      'created_at' => ['type' => 'datetime', 'null' => true],
      'updated_at' => ['type' => 'datetime', 'null' => true],
      'deleted_at' => ['type' => 'datetime', 'null' => true],
    ]);
    $this->forge->addPrimaryKey('kd_user');
    $this->forge->createTable('users');
  }

  public function down()
  {
    $this->forge->dropTable('users');
  }
}
