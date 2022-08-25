<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserPosition extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'user_id' => ['type' => 'int', 'constraint' => 11],
      'pos_id' => ['type' => 'int', 'constraint' => 2],
    ]);
    $this->forge->createTable('user_position');
  }

  public function down()
  {
    $this->forge->dropTable('user_position');
  }
}
