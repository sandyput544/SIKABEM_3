<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Positions extends BaseController
{
  protected $users_model;
  protected $positions_model;
  protected $pos_menu_model;
  public function __construct()
  {
    helper('bem');
    $this->users_model = new \App\Models\UsersModel();
    $this->positions_model = new \App\Models\PositionsModel();
    $this->pos_menu_model = new \App\Models\PositionMenuModel();
  }

  // Menampilkan list jabatan jabatan anggota BEM PNC -> Start
  public function index()
  {
    $data = [
      'title'       => 'Master Jabatan',
      'navbar'      => 'Master Jabatan',
      'card'        => 'List Jabatan',
      'positions'   => $this->positions_model->findAll()
    ];

    return view('positions/index', $data);
  }
  // End <--

  // Fitur tambah jabatan --> Start
  public function add()
  {
    $data = [
      'title'       => 'Tambah Jabatan',
      'navbar'      => 'Master Jabatan',
      'card'        => 'Form Tambah Jabatan',
      'validation'  => \Config\Services::validation()
    ];

    return view('positions/add', $data);
  }
  public function insert()
  {
    $getName = $this->request->getVar('nama_jbt');
    $getAcronim = $this->request->getVar('singkatan_jbt');
    $getSeat = $this->request->getVar('jml_kursi');
    $getActive = $this->request->getVar('jbt_active');

    // Cek kolom jbt_active
    if ($getActive == null) {
      $jbt_active = 0;
    } else {
      $jbt_active = 1;
    }

    // Validasi input tambah jabatan
    $validate = [
      'nama_jbt' => [
        'rules' => 'required|is_unique[positions.nama_jbt]',
        'errors' => [
          'required' => 'Mohon isi kolom nama jabatan.',
          'is_unique' => 'Nama jabatan sudah terdaftar.'
        ]
      ],
      'singkatan_jbt' => [
        'rules' => 'required|alpha_numeric_punct|is_unique[positions.singkatan_jbt]',
        'errors' => [
          'required' => 'Mohon isi kolom singkatan jabatan.',
          'alpha_numeric_punct' => 'Yang anda masukkan bukan karakter alfabet, numerik dan tanda baca.',
          'is_unique' => 'Singkatan jabatan sudah terdaftar.'
        ]
      ],
      'jml_kursi' => [
        'rules' => 'required|numeric',
        'errors' => [
          'required' => 'Mohon isi kolom jumlah kursi jabatan.',
          'numeric' => 'Yang anda masukkan bukan karakter numerik.'
        ]
      ],
    ];

    if (!$this->validate($validate)) {
      return redirect()->to(base_url('/jabatan/tambah'))->withInput();
    } else {
      $this->positions_model->save([
        'nama_jbt' => $getName,
        'singkatan_jbt' => $getAcronim,
        'jml_kursi' => $getSeat,
        'jbt_active' => $jbt_active,
      ]);

      $msg = "Anda berhasil menambah jabatan " . $getName . ".";
      flashAlert('success', $msg);
      return redirect()->to(base_url('/jabatan'));
    }
  }
  // End <--

  // Fitur ubah jabatan --> Start
  public function edit($id)
  {
    $data = [
      'title'       => 'Edit Jabatan',
      'navbar'      => 'Master Jabatan',
      'card'        => 'Form Edit Jabatan',
      'position'    => $this->positions_model->find($id),
      'validation'  => \Config\Services::validation()
    ];

    return view('positions/edit', $data);
  }
  public function update($id)
  {
    $getName = $this->request->getVar('nama_jbt');
    $getAcronim = $this->request->getVar('singkatan_jbt');
    $getSeat = $this->request->getVar('jml_kursi');
    $getActive = $this->request->getVar('jbt_active');

    // Cek kolom jbt_active
    if ($getActive == null) {
      $jbt_active = 0;
    } else {
      $jbt_active = 1;
    }

    // Cek apakah nama baru = nama lama
    $getPos = $this->positions_model->find($id);
    if ($getName != $getPos['nama_jbt']) {
      $ruleName = 'required|is_unique[positions.nama_jbt]';
    } else {
      $ruleName = 'required';
    }
    if ($getAcronim != $getPos['singkatan_jbt']) {
      $ruleAcronim = 'required|alpha_numeric_punct|is_unique[positions.singkatan_jbt]';
    } else {
      $ruleAcronim = 'required|alpha_numeric_punct';
    }

    $validate = [
      'nama_jbt' => [
        'rules' => $ruleName,
        'errors' => [
          'required' => 'Mohon isi kolom nama jabatan.',
          'is_unique' => 'Nama jabatan sudah terdaftar.'
        ]
      ],
      'singkatan_jbt' => [
        'rules' => $ruleAcronim,
        'errors' => [
          'required' => 'Mohon isi kolom singkatan jabatan.',
          'alpha_numeric_punct' => 'Yang anda masukkan bukan karakter alfabet, numerik dan tanda baca.',
          'is_unique' => 'Singkatan jabatan sudah terdaftar.'
        ]
      ],
      'jml_kursi' => [
        'rules' => 'required|numeric',
        'errors' => [
          'required' => 'Mohon isi kolom jumlah kursi jabatan.',
          'numeric' => 'Yang anda masukkan bukan karakter numerik.'
        ]
      ],
    ];

    if (!$this->validate($validate)) {
      return redirect()->to(base_url('/jabatan/edit/' . $id))->withInput();
    } else {
      $this->positions_model->save([
        'kd_jabatan' => $id,
        'nama_jbt' => $getName,
        'singkatan_jbt' => $getAcronim,
        'jml_kursi' => $getSeat,
        'jbt_active' => $jbt_active,
      ]);
      $msg = "Anda berhasil memperbarui jabatan user.";
      flashAlert('success', $msg);
      return redirect()->to(base_url('/jabatan'));
    }
  }
  // End <--

  // Fitur Delete Jabatan --> Start
  public function delete($id)
  {
    $getPos = $this->positions_model->find($id);
    $this->positions_model->save(['kd_jabatan' => $id, 'jbt_active' => '0']);

    // Hapus kd jabatan dari data user
    $getUsers = $this->users_model->where(['kd_jabatan' => $id])->findAll();
    foreach ($getUsers as $u) {
      $this->users_model->save(['kd_user' => $u['kd_user'], 'kd_jabatan' => 0]);
    }

    $this->positions_model->delete($id);

    $msg = "Anda berhasil menghapus jabatan " . $getPos['nama_jbt'];
    flashAlert('success', $msg);
    return redirect()->to(base_url('/jabatan'));
  }
  // End <--

  // Fitur Tampil Jabatan Terhapus --> Start
  public function show_all_deleted()
  {
    $data = [
      'title' => 'Jabatan Terhapus',
      'navbar' => 'Master Jabatan',
      'card'  => 'List Jabatan Terhapus',
      'positions' => $this->positions_model->onlyDeleted()->findAll(),
    ];
    return view('positions/deleted', $data);
  }
  // End <--

  // Fitur Restore Jabatan Terhapus --> Start
  public function restore_one($id)
  {
    $this->positions_model->save(['kd_jabatan' => $id, 'deleted_at' => null]);

    $getPos = $this->positions_model->find($id);

    $msg = "Berhasil memulihkan " . $getPos['nama_jbt'] . ".";
    flashAlert('success', $msg);
    return redirect()->to(base_url('/jabatan/terhapus'));
  }
  // End <--

  // Fitur RestoreAll Jabatan Terhapus --> Start
  public function restore_all()
  {
    $this->positions_model
      ->set(['deleted_at' => null])
      ->update();

    $msg = "Berhasil memulihkan semua jabatan yang terhapus.";
    flashAlert('success', $msg);
    return redirect()->to(base_url('/jabatan/terhapus'));
  }
  // End <--

  // Fitur DeletePermament Jabatan Terhapus --> Start
  public function permanent_delete_all()
  {
    // Hapus semua hak akses menu
    $getJabatan = $this->positions_model->onlyDeleted()->findAll();
    foreach ($getJabatan as $j) {
      $this->pos_menu_model->where('kd_jabatan', $j['kd_jabatan'])->delete();
    }

    $this->positions_model->purgeDeleted();

    $msg = "Berhasil menghapus permanen semua jabatan yang terhapus. Semua data tersebut tidak dapat dikembalikan/dipulihkan.";
    flashAlert('success', $msg);
    return redirect()->to(base_url('/jabatan/terhapus'));
  }

  public function permanent_delete_one($id)
  {
    // hapus semua hak akses menu
    $this->pos_menu_model->where('kd_jabatan', $id)->delete();

    // Ambil nama jabatan
    $getPos = $this->positions_model->onlyDeleted()->find($id);
    $msg = "Berhasil menghapus permanen " . $getPos['nama_jbt'] . ". Data " . $getPos['nama_jbt'] . " tidak bisa dikembalikan/dipulihkan.";

    $this->positions_model->where(['kd_jabatan' => $id])->purgeDeleted();

    flashAlert('success', $msg);
    return redirect()->to(base_url('/jabatan/terhapus'));
  }
  // End <--
}
