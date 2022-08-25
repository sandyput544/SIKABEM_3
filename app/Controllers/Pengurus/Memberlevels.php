<?php

namespace App\Controllers\Pengurus;

use App\Models\MemberLevelMenuAccessesModel;
use App\Models\UserMenuAccessModel;
use App\Models\UserMenuModel;
use App\Models\MemberLevelsModel;
use App\Models\DepartmentsModel;
use App\Controllers\BaseController;

class Memberlevels extends BaseController
{
  protected $user_menu_Model;
  protected $umaccess_Model;
  protected $level_access_Model;
  protected $departmentsModel;
  protected $member_levels_Model;

  public function __construct()
  {
    $this->umaccess_Model = new UserMenuAccessModel();
    $this->user_menu_Model = new UserMenuModel();
    $this->level_access_Model = new MemberLevelMenuAccessesModel();
    $this->departmentsModel = new DepartmentsModel();
    $this->member_levels_Model = new MemberLevelsModel();
  }

  public function index()
  {

    $data = [
      'title'         => 'Data Level Anggota',
      'navbar'        => 'Level Anggota',
      'curr_page'     => 'List Level Anggota',
      'member_levels'  => $this->member_levels_Model
        ->join('departments', 'departments.dept_id = member_levels.dept_id')
        ->FindAll()
    ];
    return view('/pengurus/level-anggota/index', $data);
  }

  // Create Start
  public function add()
  {
    $data = [
      'title'           => 'Tambah Data Level Anggota',
      'navbar'          => 'Anggota',
      'curr_page'       => 'Tambah Data Level Anggota',
      'form'            => 'Form Tambah Data Level',
      'departments'     => $this->departmentsModel->findAll(),
      'validation'      => \Config\Services::validation()
    ];
    return view('/pengurus/level-anggota/tambah', $data);
  }

  public function save()
  {
    $getDeptID = implode(",", $this->departmentsModel->findColumn('dept_id'));
    $errors = [
      'memberlevel_name' => [
        'rules'   => 'alpha_numeric_space|required|is_unique[member_levels.memberlevel_name]',
        'errors'  => [
          'alpha_numeric_space' => 'Mohon isi kolom nama level anggota dengan alfabet dan nomor.',
          'required'    => 'Kolom nama level anggota harus diisi.',
          'is_unique'   => 'Kolom nama level anggota sudah terdaftar.'
        ]
      ],
      'memberlevel_seats' => [
        'rules'   => 'required|is_natural_no_zero|numeric',
        'errors'  => [
          'required'            => 'Mohon isi jumlah kursi level anggota.',
          'is_natural_no_zero'  => 'Mohon isi jumlah kursi level anggota dengan angka lebih dari 0.',
          'numeric'             => 'Mohon isi jumlah kursi level anggota dengan angka lebih dari 0.'
        ]
      ],
      'dept_id' => [
        'rules'   => 'in_list[' . $getDeptID . ']',
        'errors'  => [
          'in_list'   => 'Mohon pilih departemen terlebih dahulu.',
        ]
      ]
    ];

    if (!$this->validate($errors)) {
      return redirect()->to(base_url() . '/pengurus/level-anggota/tambah')->withInput();
    }

    $this->member_levels_Model->save([
      'dept_id' => $this->request->getVar('dept_id'),
      'memberlevel_name' => htmlspecialchars($this->request->getVar('memberlevel_name')),
      'memberlevel_seats' => htmlspecialchars($this->request->getVar('memberlevel_seats')),
    ]);

    session()->setFlashdata('pesan', 'Berhasil menambahkan ' . htmlspecialchars($this->request->getVar('memberlevel_name')) . ' ke tabel level anggota.');

    return redirect()->to(base_url() . '/pengurus/level-anggota');
  }
  // Create End

  // Edit Start
  public function edit($id)
  {
    $member_levels = $this->member_levels_Model->find($id);
    $data = [
      'title'           => 'Ubah Data Level Anggota',
      'navbar'          => 'Anggota',
      'curr_page'       => 'Ubah Data Level Anggota',
      'form'            => 'Form Ubah Data Level Anggota',
      'departments'     => $this->departmentsModel->findAll(),
      'validation'      => \Config\Services::validation(),
      'member_levels'    => $member_levels
    ];

    return view('/pengurus/level-anggota/edit', $data);
  }

  public function update($id)
  {
    $member_levels = $this->member_levels_Model->find($id);

    if ($member_levels['memberlevel_name'] == $this->request->getVar('memberlevel_name')) {
      $rule_name = 'alpha_numeric_space|required[member_levels.memberlevel_name]';
    } else {
      $rule_name = 'alpha_numeric_space|required|is_unique[member_levels.memberlevel_name]';
    }

    $getDeptID = implode(",", $this->departmentsModel->findColumn('dept_id'));

    $errors = [
      'memberlevel_name' => [
        'rules'   => $rule_name,
        'errors'  => [
          'alpha_numeric_space' => 'Mohon isi kolom nama level anggota dengan alfabet dan nomor.',
          'required'    => 'Kolom nama level anggota harus diisi.',
          'is_unique'   => 'Kolom nama level anggota sudah terdaftar.'
        ]
      ],
      'memberlevel_seats' => [
        'rules'   => 'required|is_natural_no_zero|numeric',
        'errors'  => [
          'required'            => 'Mohon isi jumlah kursi level anggota.',
          'is_natural_no_zero'  => 'Mohon isi jumlah kursi level anggota dengan angka lebih dari 0.',
          'numeric'             => 'Mohon isi jumlah kursi level anggota dengan angka lebih dari 0.'
        ]
      ],
      'dept_id' => [
        'rules'   => 'in_list[' . $getDeptID . ']',
        'errors'  => [
          'in_list'   => 'Mohon pilih departemen terlebih dahulu.',
        ]
      ]
    ];

    if (!$this->validate($errors)) {
      return redirect()->to(base_url() . '/pengurus/level-anggota/edit/' . $id)->withInput();
    }

    $this->member_levels_Model->save([
      'memberlevel_id' => $id,
      'dept_id' => htmlspecialchars($this->request->getVar('dept_id')),
      'memberlevel_name' => htmlspecialchars($this->request->getVar('memberlevel_name')),
      'memberlevel_seats' => htmlspecialchars($this->request->getVar('memberlevel_seats')),
    ]);

    session()->setFlashdata('pesan', 'Berhasil memperbarui ' . htmlspecialchars($this->request->getVar('memberlevel_name')) . '.');

    return redirect()->to(base_url() . '/pengurus/level-anggota');
  }
  // Edit End

  // Delete Start
  public function delete($id)
  {
    $this->member_levels_Model->delete($id);
    $getName = $this->member_levels_Model->onlyDeleted()->find($id);

    session()->setFlashdata('pesan', 'Level anggota organisasi ' . $getName['memberlevel_name'] . ' berhasil dihapus.');
    return redirect()->to(base_url() . '/pengurus/level-anggota');
  }
  // Delete End

  // Deleted Page Start
  public function deleted()
  {
    $data = [
      'title'           => 'Data Level Anggota Yang Terhapus',
      'navbar'          => 'Anggota',
      'curr_page'       => 'Data Level Anggota Yang Terhapus',
      'validation'      => \Config\Services::validation(),
      'member_levels'    => $this->member_levels_Model
        ->onlyDeleted()
        ->join('departments', 'departments.dept_id = member_levels.dept_id')
        ->findAll()
    ];
    return view('pengurus/level-anggota/terhapus', $data);
  }

  public function restore($id)
  {
    $this->member_levels_Model->onlyDeleted()->where('memberlevel_id', $id)->set(['deleted_at' => null])->update();

    $getName = $this->member_levels_Model->find($id);

    session()->setFlashdata('pesan', 'Berhasil mengembalikan ' . $getName['memberlevel_name'] . ' ke tabel level anggota.');
    return redirect()->to(base_url() . '/pengurus/level-anggota');
  }

  public function restoreAll()
  {
    $this->member_levels_Model->onlyDeleted()->set(['deleted_at' => null])->update();

    session()->setFlashdata('pesan', 'Berhasil mengembalikan semua level yang terhapus ke tabel level anggota.');
    return redirect()->to(base_url() . '/pengurus/level-anggota');
  }

  public function clean()
  {
    $this->member_levels_Model->purgeDeleted();
    session()->setFlashdata('pesan', 'Berhasil menghapus permanen semua level yang terhapus dari tabel level anggota.');
    return redirect()->to(base_url() . '/pengurus/level-anggota');
  }
  // Deleted Page End

  // User Akses Start
  public function level_akses($id)
  {
    $level = $this->member_levels_Model->find($id);
    $data = [
      'title'         => 'List Menu Akses ' . $level['memberlevel_name'],
      'navbar'        => 'Level Anggota',
      'curr_page'     => 'List Menu Akses ' . $level['memberlevel_name'],
      'level_id'       => $level['memberlevel_id'],
      'user_menus'    => $this->umaccess_Model
        ->join('user_menus', 'user_menus.menu_id = user_menu_accesses.menu_id')
        ->join('user_roles', 'user_roles.role_id = user_menu_accesses.role_id')
        ->where(['user_menu_accesses.role_id' => '2', 'user_menu_accesses.is_active' => '1'])
        ->findAll()
    ];
    return view('/pengurus/level-anggota/menu-akses', $data);
  }

  public function edit_akses()
  {
    $data = [
      'memberlevel_id' => $this->request->getPost('levelId'),
      'umaccess_id' => $this->request->getPost('umaccessId'),
    ];

    $get_LevelName = $this->member_levels_Model->find($this->request->getPost('levelId'));

    $get_Levelaccess = $this->level_access_Model
      ->where($data)
      ->get();

    if ($get_Levelaccess->getNumRows() < 1) {
      $this->level_access_Model->save($data);
    } else {
      $this->level_access_Model
        ->where($data)
        ->delete();
    }

    session()->setFlashdata('pesan', 'Menu akses '.$get_LevelName['memberlevel_name'].' telah diperbarui.');
  }
  // User Akses End
}
