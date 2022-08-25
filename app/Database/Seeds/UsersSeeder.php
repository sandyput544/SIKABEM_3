<?php

namespace App\Database\Seeds;

use CodeIgniter\I18n\Time;
use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
  public function run()
  {
    $time = new Time('now');
    $data = [
      [
        'username' => 'anyaresti01',
        'fullname' => 'Anya Resti Oktavia',
        'email' => 'sandypermana732@gmail.com',
        'password' => 'anya123',
        'password_hash' => password_hash('anya123', PASSWORD_DEFAULT),
        'alamat' => null,
        'no_hp' => null,
        'tgl_lahir' => null,
        'foto_profil' => null,
        'is_active' => 1,
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'username' => 'sandypermana701@gmail.com',
        'fullname' => 'Sandy Permana Putra',
        'email' => 'sandypermana701@gmail.com',
        'password' => 'sandy123',
        'password_hash' => password_hash('sandy123', PASSWORD_DEFAULT),
        'alamat' => null,
        'no_hp' => null,
        'tgl_lahir' => null,
        'foto_profil' => null,
        'is_active' => 1,
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'username' => 'temanpakjokowi',
        'fullname' => 'Aji Trismanto',
        'email' => 'ajitrismanto@gmail.com',
        'password' => 'ajitris123',
        'password_hash' => password_hash('ajitris123', PASSWORD_DEFAULT),
        'alamat' => null,
        'no_hp' => null,
        'tgl_lahir' => null,
        'foto_profil' => null,
        'is_active' => 1,
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
      [
        'username' => 'eddievandermeer',
        'fullname' => 'Eddie van der Meer',
        'email' => 'eddiemusic@gmail.com',
        'password' => 'eddiev123',
        'password_hash' => password_hash('eddiev123', PASSWORD_DEFAULT),
        'alamat' => null,
        'no_hp' => null,
        'tgl_lahir' => null,
        'foto_profil' => null,
        'is_active' => 1,
        'created_at' => $time,
        'updated_at' => $time,
        'deleted_at' => null,
      ],
    ];

    $this->db->table('users')->insertBatch($data);
  }
}
