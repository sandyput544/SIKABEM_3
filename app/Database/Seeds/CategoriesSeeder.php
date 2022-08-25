<?php

namespace App\Database\Seeds;

use CodeIgniter\I18n\Time;
use CodeIgniter\Database\Seeder;

class FoldersSeeder extends Seeder
{
  public function run()
  {
    $time = new Time('now');
    $data = [
      [
        'folder_name' => 'Laporan Kegiatan',
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'folder_name' => 'Laporan Acara',
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'folder_name' => 'Laporan Pertanggungjawaban',
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'folder_name' => 'Proposal Kegiatan',
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'folder_name' => 'Buku Anggaran Dasar/Anggaran Rumah Tangga',
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'folder_name' => 'Surat Masuk',
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'folder_name' => 'Surat Keluar',
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
    ];

    $this->db->table('folders')->insertBatch($data);
  }
}
