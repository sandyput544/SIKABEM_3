<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Menus extends BaseController
{
  protected $menus_model;
  public function __construct()
  {
    helper('bem');
    $this->menus_model = new \App\Models\MenusModel();
  }

  // Menampilkan list menu -> Start
  public function index()
  {
    $data = [
      'title'       => 'Master Menu',
      'navbar'      => 'Master Menu',
      'card'        => 'List Menu',
      'menus'       => $this->menus_model
        ->where('menu_name!="Master Menu"')
        ->findAll()
    ];

    return view('menus/index', $data);
  }
  // End <--

  // Fitur tambah menu --> Start
  public function add()
  {
    $data = [
      'title'       => 'Tambah Menu',
      'navbar'      => 'Master Menu',
      'card'        => 'Form Tambah Menu',
      'validation'  => \Config\Services::validation()
    ];

    return view('menus/add', $data);
  }
  public function insert()
  {
    // Validasi input tambah menu
    $validate = [
      'menu_name' => [
        'rules' => 'required|alpha_space|is_unique[menus.menu_name]',
        'errors' => [
          'required' => 'Mohon isi kolom nama menu.',
          'alpha_space' => 'Yang anda masukkan bukan karakter alfabet dan spasi.',
          'is_unique' => 'Nama menu sudah terdaftar.'
        ]
      ],
      'menu_url' => [
        'rules' => 'required|alpha_dash|is_unique[menus.menu_url]',
        'errors' => [
          'required' => 'Mohon isi kolom menu url.',
          'alpha_dash' => 'Yang anda masukkan bukan alfanumerik dan tanda pisah garis.',
          'is_unique' => 'Menu url sudah terdaftar.'
        ]
      ],
      'menu_icon' => [
        'rules' => 'required|alpha_dash',
        'errors' => [
          'required' => 'Mohon isi kolom icon.',
          'alpha_dash' => 'Yang anda masukkan bukan alfanumerik dan tanda pisah garis.',
        ]
      ]
    ];

    if (!$this->validate($validate)) {
      return redirect()->to(base_url('/menu/tambah'))->withInput();
    }

    // HTMLSpecialChars
    $postName = htmlspecialchars($this->request->getVar('menu_name'));
    $postUrl = htmlspecialchars($this->request->getVar('menu_url'));
    $postIcon = htmlspecialchars($this->request->getVar('menu_icon'));
    $postIsActive = htmlspecialchars($this->request->getVar('is_active'));

    // Cek kolom is_active
    if ($postIsActive == null) {
      $is_active = 0;
    } else {
      $is_active = 1;
    }

    $this->menus_model->save([
      'menu_name' => $postName,
      'menu_url' => $postUrl,
      'menu_icon' => $postIcon,
      'is_active' => $is_active,
    ]);

    $msg = "Anda berhasil menambah menu " . $postName . ".";
    flashAlert('success', $msg);
    return redirect()->to(base_url('/menu'));
  }
  // End <--

  // Fitur ubah menu --> Start
  public function edit($id)
  {
    $data = [
      'title'       => 'Edit Menu',
      'navbar'      => 'Master Menu',
      'card'        => 'Form Edit Menu',
      'menus'       => $this->menus_model->find($id),
      'validation'  => \Config\Services::validation()
    ];

    return view('menus/edit', $data);
  }
  public function update($id)
  {
    // Validasi input update menu
    $getMenu = $this->menus_model->find($id);
    $postName = htmlspecialchars($this->request->getVar('menu_name'));
    $postUrl = htmlspecialchars($this->request->getVar('menu_url'));
    $postIcon = htmlspecialchars($this->request->getVar('menu_icon'));
    $postIsActive = htmlspecialchars($this->request->getVar('is_active'));
    if ($postName != $getMenu['menu_name']) {
      $ruleName = 'required|alpha_space|is_unique[menus.menu_name]';
    } else {
      $ruleName = 'required|alpha_space';
    }

    if ($postUrl != $getMenu['menu_url']) {
      $ruleUrl = 'required|alpha_dash|is_unique[menus.menu_url]';
    } else {
      $ruleUrl = 'required|alpha_dash';
    }

    $validate = [
      'menu_name' => [
        'rules' => $ruleName,
        'errors' => [
          'required' => 'Mohon isi kolom nama menu.',
          'alpha_space' => 'Yang anda masukkan bukan karakter alfabet dan spasi.',
          'is_unique' => 'Nama menu sudah terdaftar.'
        ]
      ],
      'menu_url' => [
        'rules' => $ruleUrl,
        'errors' => [
          'required' => 'Mohon isi kolom menu url.',
          'alpha_dash' => 'Yang anda masukkan bukan alfanumerik dan tanda pisah garis.',
          'is_unique' => 'Menu url sudah terdaftar.'
        ]
      ],
      'menu_icon' => [
        'rules' => 'required|alpha_dash',
        'errors' => [
          'required' => 'Mohon isi kolom nama posisi.',
          'alpha_dash' => 'Yang anda masukkan bukan alfanumerik dan tanda pisah garis.',
        ]
      ],
    ];

    if (!$this->validate($validate)) {
      return redirect()->to(base_url('/menu/edit/' . $id))->withInput();
    }

    // Cek kolom is_active
    if ($postIsActive == null) {
      $is_active = 0;
    } else {
      $is_active = 1;
    }

    $this->menus_model->save([
      'id' => $id,
      'menu_name' => $postName,
      'menu_url' => $postUrl,
      'menu_icon' => $postIcon,
      'is_active' => $is_active,
    ]);
    $msg = "Anda berhasil memperbarui menu.";
    flashAlert('success', $msg);
    return redirect()->to(base_url('/menu'));
  }
  // End <--

  // Fitur Delete Menu --> Start
  public function delete($id)
  {
    $getMenu = $this->menus_model->find($id);
    $msg = "Berhasil menghapus menu " . $getMenu['menu_name'] . ".";

    // set is_active = 0
    $this->menus_model->save(['id' => $id, 'is_active' => 0]);

    $this->menus_model->delete($id);

    flashAlert('success', $msg);
    return redirect()->to(base_url('/menu'));
  }
  // End <--

  // Fitur Tampil Menu Terhapus --> Start
  public function show_all_deleted()
  {
    $data = [
      'title'         => 'Menu Terhapus',
      'navbar'        => 'Master Menu',
      'card'          => 'List Menu Terhapus',
      'menus'         => $this->menus_model->onlyDeleted()->findAll(),
    ];
    return view('menus/deleted', $data);
  }
  // End <--

  // Fitur Restore Menu Terhapus --> Start
  public function restore_one($id)
  {
    $getPos = $this->menus_model->onlyDeleted()->find($id);

    $this->menus_model
      ->save(['id' => $id, 'deleted_at' => null]);

    $msg = "Berhasil mengembalikan " . $getPos['menu_name'] . ".";
    flashAlert('success', $msg);
    return redirect()->to(base_url('menu/terhapus'));
  }
  // End <--

  // Fitur RestoreAll Menu Terhapus --> Start
  public function restore_all()
  {
    $this->menus_model
      ->set(['deleted_at' => null])
      ->update();

    $msg = "Berhasil mengembalikan semua menu yang terhapus.";
    flashAlert('success', $msg);
    return redirect()->to(base_url('menu/terhapus'));
  }
  // End <--

  // Fitur DeletePermament Menu Terhapus --> Start
  public function permanent_delete_all()
  {
    $this->menus_model->purgeDeleted();

    $msg = "Berhasil menghapus permanen semua menu yang terhapus. Data yang dihapus secara permanen tidak dapat dipulihkan.";
    flashAlert('success', $msg);
    return redirect()->to(base_url('menu/terhapus'));
  }
  public function permanent_delete_one($id)
  {
    $getName = $this->menus_model->onlyDeleted()->find($id);
    $msg = "Berhasil menghapus permanen menu " . $getName['menu_name'] . ". Data yang dihapus secara permanen tidak dapat dipulihkan.";

    $this->menus_model->where('id', $id)->purgeDeleted();

    flashAlert('success', $msg);
    return redirect()->to(base_url('/menu/terhapus'));
  }
  // End <--
}
