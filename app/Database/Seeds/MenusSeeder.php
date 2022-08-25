<?php

namespace App\Database\Seeds;

use CodeIgniter\I18n\Time;
use CodeIgniter\Database\Seeder;

class MenusSeeder extends Seeder
{
  public function run()
  {
    $time = new Time('now');
    $data = [
      [
        'menu_name' => 'Master User',
        'menu_url' => 'user',
        'menu_icon' => 'bi-people-fill',
        'is_active' => 1,
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'menu_name' => 'Master Posisi',
        'menu_url' => 'posisi',
        'menu_icon' => 'bi-diagram-2-fill',
        'is_active' => 1,
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'menu_name' => 'Master Menu',
        'menu_url' => 'menu',
        'menu_icon' => 'bi-ui-checks',
        'is_active' => 1,
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'menu_name' => 'Master Kategori',
        'menu_url' => 'kategori',
        'menu_icon' => 'bi-tag-fill',
        'is_active' => 1,
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'menu_name' => 'Master Arsip',
        'menu_url' => 'arsip',
        'menu_icon' => 'bi-archive-fill',
        'is_active' => 1,
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'menu_name' => 'Koleksi Arsip',
        'menu_url' => 'koleksi',
        'menu_icon' => 'bi-bookshelf',
        'is_active' => 1,
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
    ];

    $this->db->table('menus')->insertBatch($data);
  }
}
