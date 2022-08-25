<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OutgoingMail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kd_suratkeluar' => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
            'kd_jenissurat' => ['type' => 'int', 'constraint' => 3],
            'nomor_surat' => ['type' => 'varchar', 'constraint' => 15],
            'kd_user' => ['type' => 'int', 'constraint' => 11],
            'tgl_buat' => ['type' => 'varchar', 'constraint' => 25],
            'tgl_ttd' => ['type' => 'varchar', 'constraint' => 25],
            'perihal' => ['type' => 'varchar', 'constraint' => 15],
            'lampiran' => ['type' => 'varchar', 'constraint' => 10],
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true],
            'deleted_at' => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('kd_suratkeluar');
        $this->forge->createTable('outgoing_mail');
    }

    public function down()
    {
        $this->forge->dropTable('outgoing_mail');
    }
}
