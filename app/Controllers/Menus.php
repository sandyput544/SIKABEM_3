<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Menus extends BaseController
{
  protected $menus_model;
  protected $pos_menu;
  public function __construct()
  {
    helper('bem');
    $this->menus_model = new \App\Models\MenusModel();
    $this->pos_menu = new \App\Models\PositionMenuModel();
  }

  // Menampilkan list menu -> Start
  public function index()
  {
    $data = [
      'title'       => 'Master Menu',
      'navbar'      => 'Master Menu',
      'card'        => 'List Menu',
      'menus'       => $this->menus_model->findAll()
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
      'nama_menu' => [
        'rules' => 'required|alpha_space|is_unique[menus.nama_menu]',
        'errors' => [
          'required' => 'Mohon isi kolom nama menu.',
          'alpha_space' => 'Yang anda masukkan bukan karakter alfabet dan spasi.',
          'is_unique' => 'Nama menu sudah terdaftar.'
        ]
      ],
      'url_menu' => [
        'rules' => 'required|alpha_dash|is_unique[menus.url_menu]',
        'errors' => [
          'required' => 'Mohon isi kolom menu url.',
          'alpha_dash' => 'Yang anda masukkan bukan alfanumerik dan tanda pisah garis.',
          'is_unique' => 'Menu url sudah terdaftar.'
        ]
      ],
      'ikon_menu' => [
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
    $postName = htmlspecialchars($this->request->getVar('nama_menu'));
    $postUrl = htmlspecialchars($this->request->getVar('url_menu'));
    $postIcon = htmlspecialchars($this->request->getVar('ikon_menu'));
    $postIsActive = htmlspecialchars($this->request->getVar('menu_active'));

    // Cek kolom menu_active
    if ($postIsActive == null) {
      $menu_active = 0;
    } else {
      $menu_active = 1;
    }

    $this->menus_model->save([
      'nama_menu' => $postName,
      'url_menu' => $postUrl,
      'ikon_menu' => $postIcon,
      'menu_active' => $menu_active,
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
    $postName = htmlspecialchars($this->request->getVar('nama_menu'));
    $postUrl = htmlspecialchars($this->request->getVar('url_menu'));
    $postIcon = htmlspecialchars($this->request->getVar('ikon_menu'));
    $postIsActive = htmlspecialchars($this->request->getVar('menu_active'));
    if ($postName != $getMenu['nama_menu']) {
      $ruleName = 'required|alpha_space|is_unique[menus.nama_menu]';
    } else {
      $ruleName = 'required|alpha_space';
    }

    if ($postUrl != $getMenu['url_menu']) {
      $ruleUrl = 'required|alpha_dash|is_unique[menus.url_menu]';
    } else {
      $ruleUrl = 'required|alpha_dash';
    }

    $validate = [
      'nama_menu' => [
        'rules' => $ruleName,
        'errors' => [
          'required' => 'Mohon isi kolom nama menu.',
          'alpha_space' => 'Yang anda masukkan bukan karakter alfabet dan spasi.',
          'is_unique' => 'Nama menu sudah terdaftar.'
        ]
      ],
      'url_menu' => [
        'rules' => $ruleUrl,
        'errors' => [
          'required' => 'Mohon isi kolom menu url.',
          'alpha_dash' => 'Yang anda masukkan bukan alfanumerik dan tanda pisah garis.',
          'is_unique' => 'Menu url sudah terdaftar.'
        ]
      ],
      'ikon_menu' => [
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

    // Cek kolom menu_active
    if ($postIsActive == null) {
      $menu_active = 0;
    } else {
      $menu_active = 1;
    }

    $this->menus_model->save([
      'kd_menu' => $id,
      'nama_menu' => $postName,
      'url_menu' => $postUrl,
      'ikon_menu' => $postIcon,
      'menu_active' => $menu_active,
    ]);
    $msg = "Anda berhasil memperbarui menu" . $postName . ".";
    flashAlert('success', $msg);
    return redirect()->to(base_url('/menu'));
  }
  // End <--

  // Fitur Delete Menu --> Start
  public function delete($id)
  {
    $getMenu = $this->menus_model->find($id);
    $msg = "Berhasil menghapus menu " . $getMenu['nama_menu'] . ".";

    // set menu_active = 0
    $this->menus_model->save(['kd_menu' => $id, 'menu_active' => 0]);

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
      ->save(['kd_menu' => $id, 'deleted_at' => null]);

    $msg = "Berhasil mengembalikan " . $getPos['nama_menu'] . ".";
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
    // Hapus semua menu dari posisi menu
    $getMenus = $this->menus_model->onlyDeleted()->findAll();
    foreach ($getMenus as $m) {
      $this->pos_menu->where('kd_menu', $m['kd_menu'])->delete();
    }

    $this->menus_model->purgeDeleted();

    $msg = "Berhasil menghapus permanen semua menu yang terhapus. Data yang dihapus secara permanen tidak dapat dipulihkan.";
    flashAlert('success', $msg);
    return redirect()->to(base_url('menu/terhapus'));
  }
  public function permanent_delete_one($id)
  {
    $this->pos_menu->where('kd_menu', $id)->delete();

    $getName = $this->menus_model->onlyDeleted()->find($id);
    $msg = "Berhasil menghapus permanen menu " . $getName['nama_menu'] . ". Data yang dihapus secara permanen tidak dapat dipulihkan.";

    $this->menus_model->where('kd_menu', $id)->purgeDeleted();

    flashAlert('success', $msg);
    return redirect()->to(base_url('/menu/terhapus'));
  }
  // End <--
}
