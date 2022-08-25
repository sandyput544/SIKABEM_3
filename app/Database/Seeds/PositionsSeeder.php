<?php

namespace App\Database\Seeds;

use CodeIgniter\I18n\Time;
use CodeIgniter\Database\Seeder;

class PositionsSeeder extends Seeder
{
  public function run()
  {
    $time = new Time('now');
    $data = [
      [
        'pos_name' => 'Pembina',
        'is_active' => '1',
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'pos_name' => 'Ketua',
        'is_active' => '1',
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'pos_name' => 'Wakil Ketua',
        'is_active' => '1',
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'pos_name' => 'Sekretaris Jenderal',
        'is_active' => '1',
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'pos_name' => 'Bendahara 1',
        'is_active' => '1',
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'pos_name' => 'Bendahara 2',
        'is_active' => '1',
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'pos_name' => 'Deputi Administrasi',
        'is_active' => '1',
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'pos_name' => 'Deputi Persidangan',
        'is_active' => '1',
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'pos_name' => 'Kepala Departemen Dalam Kampus',
        'is_active' => '1',
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'pos_name' => 'Kepala Departemen Luar Kampus',
        'is_active' => '1',
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'pos_name' => 'Kepala Departemen Administrasi dan Kesekretariatan',
        'is_active' => '1',
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'pos_name' => 'Kepala Departemen Pemberdayaan Sumber Daya Mahasiswa',
        'is_active' => '1',
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'pos_name' => 'Kepala Departemen Komunikasi dan Informasi',
        'is_active' => '1',
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
    ];
    $this->db->table('positions')->insertBatch($data);
  }
}
