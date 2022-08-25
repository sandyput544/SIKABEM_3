<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
      'fullname' => ['type' => 'varchar', 'constraint' => 128],
      'birthdate' => ['type' => 'date', 'null' => true],
      'gender' => ['type' => 'enum', 'constraint' => ['Pria', 'Wanita']],
      'religion' => ['type' => 'enum', 'constraint' => ['Buddha', 'Hindhu', 'Islam', 'Katholik', 'Konghucu', 'Kristen Protestan']],
      'address' => ['type' => 'text', 'null' => true],
      'phone' => ['type' => 'varchar', 'constraint' => 13],
      'email' => ['type' => 'varchar', 'constraint' => 128],
      'password' => ['type' => 'varchar', 'constraint' => 128],
      'password_hash' => ['type' => 'varchar', 'constraint' => 128],
      'photo' => ['type' => 'varchar', 'constraint' => 128, 'null' => true],
      'is_active' => ['type' => 'int', 'constraint' => 1],
      'created_at' => ['type' => 'datetime', 'null' => true],
      'updated_at' => ['type' => 'datetime', 'null' => true],
      'deleted_at' => ['type' => 'datetime', 'null' => true],
    ]);
    $this->forge->addPrimaryKey('id');
    $this->forge->createTable('users');
  }

  public function down()
  {
    $this->forge->dropTable('users');
  }
}
