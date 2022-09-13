<?php

namespace App\Controllers;

class Categories extends BaseController
{
  protected $cat_model;
  protected $arc_model;
  public function __construct()
  {
    helper('bem');
    $this->cat_model = new \App\Models\CategoriesModel();
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
      'categories'  => $this->cat_model->orderBy('nama_kat', 'ASC')->findAll()
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
      'nama_kat' => [
        'rules' => 'required|alpha_space|is_unique[categories.nama_kat]',
        'errors' => [
          'required' => 'Mohon isi kolom nama kategori.',
          'alpha_space' => 'Yang anda masukkan bukan karakter alfabet atau spasi.',
          'is_unique' => 'Nama kategori sudah terdaftar.'
        ]
      ],
      'singkatan_kat' => [
        'rules' => 'required|alpha_numeric_punct|is_unique[categories.singkatan_kat]',
        'errors' => [
          'required' => 'Mohon isi kolom nama kategori.',
          'alpha_numeric_punct' => 'Yang anda masukkan bukan karakter alfabet, angka atau tanda baca.',
          'is_unique' => 'Nama singkatan sudah terdaftar.'
        ]
      ],
    ];

    if (!$this->validate($validate)) {
      return redirect()->to(base_url('kategori/tambah'))->withInput();
    } else {
      $postName = htmlspecialchars($this->request->getVar('nama_kat'));
      $postAcronim = htmlspecialchars($this->request->getVar('singkatan_kat'));
      $slug = url_title($postName, '-', true);

      $this->cat_model->save([
        'nama_kat' => $postName,
        'singkatan_kat' => $postAcronim,
        'slug' => $slug
      ]);

      $msg = "Anda berhasil menambah kategori " . $postName . ".";
      flashAlert('success', $msg);
      return redirect()->to(base_url('kategori'));
    }
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
    $postName = htmlspecialchars($this->request->getVar('nama_kat'));
    $postAcronim = htmlspecialchars($this->request->getVar('singkatan_kat'));
    $slug = url_title($postName, '-', true);

    if ($postName != $getCat['nama_kat']) {
      $ruleName = "required|alpha_space|is_unique[categories.nama_kat]";
    } else {
      $ruleName = "required|alpha_space";
    }
    if ($postName != $getCat['singkatan_kat']) {
      $ruleAcronim = "required|alpha_numeric_punct|is_unique[categories.nama_kat]";
    } else {
      $ruleAcronim = "required|alpha_numeric_punct";
    }

    $validate = [
      'nama_kat' => [
        'rules' => $ruleName,
        'errors' => [
          'required' => 'Mohon isi kolom nama kategori.',
          'alpha_space' => 'Yang anda masukkan bukan karakter alfabet atau spasi.',
          'is_unique' => 'Nama kategori sudah terdaftar.'
        ]
      ],
      'singkatan_kat' => [
        'rules' => $ruleAcronim,
        'errors' => [
          'required' => 'Mohon isi kolom nama kategori.',
          'alpha_numeric_punct' => 'Yang anda masukkan bukan karakter alfabet, angka atau tanda baca.',
          'is_unique' => 'Nama kategori sudah terdaftar.'
        ]
      ],
    ];

    if (!$this->validate($validate)) {
      return redirect()->to(base_url('kategori/edit/' . $id))->withInput();
    } else {
      $this->cat_model->save([
        'kd_kategori' => $id,
        'nama_kat' => $postName,
        'singkatan_kat' => $postAcronim,
        'slug' => $slug,
      ]);

      if ($postName == $getCat['nama_kat']) {
        $msg = "Anda berhasil memperbarui kategori : " . $postName . ".";
      } else {
        $msg = "Anda berhasil memperbarui kategori : " . $getCat['nama_kat'] . " <span class='bi-arrow-right'></span> " . $postName . ".";
      }
      flashAlert('success', $msg);
      return redirect()->to(base_url('kategori'));
    }
  }
  // End <--

  // Fitur Delete Kategori --> Start
  public function delete($id)
  {
    $getCat = $this->cat_model->find($id);
    $msg = "Anda berhasil menghapus kategori : " . $getCat['nama_kat'] . ".";
    // Menghapus kd_kategori dari arsip.
    $getArchives = $this->arc_model->where('kd_kategori', $id)->findAll();
    foreach ($getArchives as $a) {
      $this->arc_model->save(['kd_user' => $a['kd_user'], 'kd_kategori' => 0]);
    }

    $this->cat_model->delete($id);
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
    $this->cat_model->save(['kd_kategori' => $id, 'deleted_at' => null]);

    $getCat = $this->cat_model->find($id);

    $msg = "Berhasil memulihkan data kategori : " . $getCat['nama_kat'] . ".";
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

    $msg = "Berhasil memulihkan semua data kategori yang terhapus.";
    flashAlert('success', $msg);
    return redirect()->to(base_url('kategori/terhapus'));
  }
  // End <--

  // Fitur DeletePermament Kategori Terhapus --> Start
  public function permanent_delete_one($id)
  {
    $getCat = $this->cat_model->onlyDeleted()->find($id);
    $msg = "Berhasil menghapus permanen kategori " . $getCat['nama_kat'] . ".";

    $this->cat_model->where('kd_kategori', $id)->purgeDeleted();

    flashAlert('success', $msg);
    return redirect()->to(base_url('kategori/terhapus'));
  }
  // End <--

  // Fitur DeletePermament Kategori Terhapus --> Start
  public function permanent_delete_all()
  {
    $this->cat_model->purgeDeleted();

    $msg = "Berhasil menghapus permanen semua kategori yang terhapus.";
    flashAlert('success', $msg);
    return redirect()->to(base_url('kategori/terhapus'));
  }
  // End <--
}
