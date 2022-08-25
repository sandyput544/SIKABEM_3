<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Positions extends BaseController
{
  protected $user_pos_model;
  protected $positions_model;
  public function __construct()
  {
    helper('bem');
    $this->user_pos_model = new \App\Models\UserPositionModel();
    $this->positions_model = new \App\Models\PositionsModel();
  }

  // Menampilkan list posisi jabatan anggota BEM PNC -> Start
  public function index()
  {
    $data = [
      'title'       => 'Master Posisi',
      'navbar'      => 'Master Posisi',
      'card'        => 'List Posisi',
      'positions'   => $this->positions_model->findAll()
    ];

    return view('positions/index', $data);
  }
  // End <--

  // Fitur tambah posisi --> Start
  public function add()
  {
    $data = [
      'title'       => 'Tambah Posisi',
      'navbar'      => 'Master Posisi',
      'card'        => 'Form Tambah Posisi',
      'validation'  => \Config\Services::validation()
    ];

    return view('positions/add', $data);
  }
  public function insert()
  {
    $getName = $this->request->getVar('pos_name');
    $getActive = $this->request->getVar('is_active');

    // Cek kolom is_active
    if ($getActive == null) {
      $is_active = 0;
    } else {
      $is_active = 1;
    }

    // Validasi input tambah posisi
    $validate = [
      'pos_name' => [
        'rules' => 'required|is_unique[positions.pos_name]',
        'errors' => [
          'required' => 'Mohon isi kolom nama posisi.',
          'is_unique' => 'Nama posisi sudah terdaftar.'
        ]
      ]
    ];

    if (!$this->validate($validate)) {
      return redirect()->to(base_url('/posisi/tambah'))->withInput();
    }

    $this->positions_model->save([
      'pos_name' => $getName,
      'is_active' => $is_active,
    ]);

    $msg = "Anda berhasil menambah posisi/jabatan " . $getName . ".";
    flashAlert('success', $msg);
    return redirect()->to(base_url('/posisi'));
  }
  // End <--

  // Fitur ubah posisi --> Start
  public function edit($id)
  {
    $data = [
      'title'       => 'Edit Posisi',
      'navbar'      => 'Master Posisi',
      'card'        => 'Form Edit Posisi',
      'position'    => $this->positions_model->find($id),
      'validation'  => \Config\Services::validation()
    ];

    return view('positions/edit', $data);
  }
  public function update($id)
  {
    $getName = $this->request->getVar('pos_name');
    $getActive = $this->request->getVar('is_active');

    // Cek kolom is_active
    if ($getActive == null) {
      $is_active = 0;
    } else {
      $is_active = 1;
    }

    // Cek apakah nama baru = nama lama
    $getPos = $this->positions_model->find($id);
    if ($getName != $getPos['pos_name']) {
      $ruleName = 'required|is_unique[positions.pos_name]';
    } else {
      $ruleName = 'required';
    }

    $validate = [
      'pos_name' => [
        'rules' => $ruleName,
        'errors' => [
          'required' => 'Mohon isi kolom nama posisi.',
          'is_unique' => 'Nama posisi sudah terdaftar.'
        ]
      ]
    ];

    if (!$this->validate($validate)) {
      return redirect()->to(base_url('/posisi/edit/' . $id))->withInput();
    }

    $this->positions_model->save([
      'id' => $id,
      'pos_name' => $getName,
      'is_active' => $is_active,
    ]);
    $msg = "Anda berhasil memperbarui posisi/jabatan anggota.";
    flashAlert('success', $msg);
    return redirect()->to(base_url('/posisi'));
  }
  // End <--

  // Fitur Delete Posisi --> Start
  public function delete($id)
  {
    $getPos = $this->positions_model->find($id);
    $this->positions_model->save(['id' => $id, 'is_active' => '0']);

    $this->user_pos_model->where(['pos_id' => $id])->delete();

    $this->positions_model->delete($id);
    $msg = "Anda berhasil menghapus posisi/jabatan " . $getPos['pos_name'];
    flashAlert('success', $msg);
    return redirect()->to(base_url('/posisi'));
  }
  // End <--

  // Fitur Tampil Posisi Terhapus --> Start
  public function show_all_deleted()
  {
    $data = [
      'title' => 'Posisi Terhapus',
      'navbar'      => 'Master Posisi',
      'card'  => 'List Posisi Terhapus',
      'positions' => $this->positions_model->onlyDeleted()->findAll(),
    ];
    return view('positions/deleted', $data);
  }
  // End <--

  // Fitur Restore Posisi Terhapus --> Start
  public function restore_one($id)
  {
    $this->positions_model
      ->where(['id' => $id])
      ->save(['id' => $id, 'deleted_at' => null]);

    $getPos = $this->positions_model->find($id);

    $msg = "Berhasil memulihkan " . $getPos['pos_name'] . ".";
    flashAlert('success', $msg);
    return redirect()->to(base_url('/posisi/terhapus'));
  }
  // End <--

  // Fitur RestoreAll Posisi Terhapus --> Start
  public function restore_all()
  {
    $this->positions_model
      ->set(['deleted_at' => null])
      ->update();

    $msg = "Berhasil memulihkan semua posisi yang terhapus.";
    flashAlert('success', $msg);
    return redirect()->to(base_url('/posisi/terhapus'));
  }
  // End <--

  // Fitur DeletePermament Posisi Terhapus --> Start
  public function permanent_delete_all()
  {
    $this->positions_model->purgeDeleted();

    $msg = "Berhasil menghapus permanen semua posisi yang terhapus. Semua data tersebut tidak dapat dikembalikan/dipulihkan.";
    flashAlert('success', $msg);
    return redirect()->to(base_url('/posisi/terhapus'));
  }

  public function permanent_delete_one($id)
  {
    // Ambil nama posisi
    $getPos = $this->positions_model->onlyDeleted()->find($id);

    $msg = "Berhasil menghapus permanen " . $getPos['pos_name'] . ". Data " . $getPos['pos_name'] . " tidak bisa dikembalikan/dipulihkan.";

    $this->positions_model->where(['id' => $id])->purgeDeleted();

    flashAlert('success', $msg);
    return redirect()->to(base_url('/posisi/terhapus'));
  }
  // End <--
}
