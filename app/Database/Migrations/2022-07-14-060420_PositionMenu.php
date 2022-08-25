<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PositionMenu extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'pos_id' => ['type' => 'int', 'constraint' => 2],
      'menu_id' => ['type' => 'int', 'constraint' => 2],
    ]);
    $this->forge->createTable('position_menu');
  }

  public function down()
  {
    $this->forge->dropTable('position_menu');
  }
}
