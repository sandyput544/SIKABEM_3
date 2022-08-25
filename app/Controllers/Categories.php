<?php

namespace App\Controllers;

use App\Models\CategoriesModel;
use App\Controllers\BaseController;

class Categories extends BaseController
{
  protected $cat_model;
  protected $arc_model;
  public function __construct()
  {
    helper('bem');
    $this->cat_model = new CategoriesModel();
    $this->arc_model = new \App\Models\ArchivesModel();
  }

  // Menampilkan list folders -> Start
  public function index()
  {
    $data = [
      'title'       => 'Master Kategori',
      'navbar'      => 'Master Kategori',
      'card'        => 'List Kategori',
      'instance'    => $this->arc_model,
      'categories'  => $this->cat_model->findAll()
    ];

    return view('categories/index', $data);
  }
  // End <--

  // Fitur tambah folders --> Start
  public function add()
  {
    $data = [
      'title'       => 'Tambah Kategori',
      'navbar'      => 'Master Kategori',
      'card'        => 'Form Tambah Kategori',
      'validation'  => \Config\Services::validation()
    ];

    return view('categories/add', $data);
  }
  public function insert()
  {
    // Validasi input tambah folder
    $validate = [
      'cat_name' => [
        'rules' => 'required|alpha_space|is_unique[categories.cat_name]',
        'errors' => [
          'required' => 'Mohon isi kolom nama kategori.',
          'alpha_space' => 'Yang anda masukkan bukan karakter alfabet atau spasi.',
          'is_unique' => 'Nama menu sudah terdaftar.'
        ]
      ],
    ];

    if (!$this->validate($validate)) {
      return redirect()->to(base_url('kategori/tambah'))->withInput();
    }

    $postName = htmlspecialchars($this->request->getVar('cat_name'));
    $slug = url_title($postName, '-', true);

    $this->cat_model->save([
      'cat_name' => $postName,
      'slug' => $slug
    ]);

    $msg = "Anda berhasil menambah kategori " . $postName . ".";
    flashAlert('success', $msg);
    return redirect()->to(base_url('kategori'));
  }
  // End <--

  // Fitur ubah folders --> Start
  public function edit($id)
  {
    $data = [
      'title'       => 'Edit Kategori',
      'navbar'      => 'Master Kategori',
      'card'        => 'Form Edit Kategori',
      'category'    => $this->cat_model->find($id),
      'validation'  => \Config\Services::validation()
    ];

    return view('categories/edit', $data);
  }
  public function update($id)
  {
    // Validasi input update kategori
    $getCat = $this->cat_model->find($id);
    $postName = htmlspecialchars($this->request->getVar('cat_name'));
    $slug = url_title($postName, '-', true);

    if ($postName != $getCat['cat_name']) {
      $ruleName = "required|alpha_space|is_unique[categories.cat_name]";
    } else {
      $ruleName = "required|alpha_space";
    }

    $validate = [
      'cat_name' => [
        'rules' => $ruleName,
        'errors' => [
          'required' => 'Mohon isi kolom nama kategori.',
          'alpha_space' => 'Yang anda masukkan bukan karakter alfabet atau spasi.',
          'is_unique' => 'Nama kategori sudah terdaftar.'
        ]
      ],
    ];

    if (!$this->validate($validate)) {
      return redirect()->to(base_url('kategori/edit/' . $id))->withInput();
    }

    $this->cat_model->save([
      'id' => $id,
      'cat_name' => $postName,
      'slug' => $slug,
    ]);

    $msg = "Anda berhasil memperbarui kategori" . $postName . ".";
    flashAlert('success', $msg);
    return redirect()->to(base_url('kategori'));
  }
  // End <--

  // Fitur Delete Kategori --> Start
  public function delete($id)
  {
    $getCat = $this->cat_model->find($id);
    $this->cat_model->delete($id);
    $msg = "Anda berhasil menghapus kategori " . $getCat['cat_name'] . ".";
    flashAlert('success', $msg);
    return redirect()->to(base_url('kategori'));
  }
  // End <--

  // Fitur Tampil Kategori Terhapus --> Start
  public function show_all_deleted()
  {
    $data = [
      'title'        => 'Kategori Terhapus',
      'navbar'       => 'Master Kategori',
      'card'         => 'List Kategori Terhapus',
      'categories'   => $this->cat_model->onlyDeleted()->findAll(),
    ];
    return view('categories/deleted', $data);
  }
  // End <--

  // Fitur Restore Kategori Terhapus --> Start
  public function restore_one($id)
  {
    $this->cat_model->save(['id' => $id, 'deleted_at' => null]);

    $getCat = $this->cat_model->find($id);

    $msg = "Berhasil mengembalikan kategori " . $getCat['cat_name'] . ".";
    flashAlert('success', $msg);
    return redirect()->to(base_url('kategori/terhapus'));
  }
  // End <--

  // Fitur RestoreAll Kategori Terhapus --> Start
  public function restore_all()
  {
    $this->cat_model
      ->set(['deleted_at' => null])
      ->update();

    $msg = "Berhasil mengembalikan semua kategori yang terhapus.";
    flashAlert('success', $msg);
    return redirect()->to(base_url('kategori/terhapus'));
  }
  // End <--

  // Fitur DeletePermament Kategori Terhapus --> Start
  public function permanent_delete_one($id)
  {
    $getCat = $this->cat_model->onlyDeleted()->find($id);
    $msg = "Berhasil menghapus permanen kategori " . $getCat['cat_name'] . ". Semua data yang terhapus secara permanen tidak dapat dipulihkan.";

    $this->cat_model->where('id', $id)->purgeDeleted();

    flashAlert('success', $msg);
    return redirect()->to(base_url('kategori/terhapus'));
  }
  // End <--

  // Fitur DeletePermament Kategori Terhapus --> Start
  public function permanent_delete_all()
  {
    $this->cat_model->purgeDeleted();

    $msg = "Berhasil menghapus permanen semua kategori yang terhapus. Semua data yang terhapus secara permanen tidak dapat dipulihkan.";
    flashAlert('success', $msg);
    return redirect()->to(base_url('kategori/terhapus'));
  }
  // End <--
}
