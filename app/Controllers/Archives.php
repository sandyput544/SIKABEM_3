<?php

namespace App\Controllers;

use \App\Models\CategoriesModel;
use \App\Models\ArchivesModel;

class Archives extends BaseController
{
  protected $arc_model;
  protected $cat_model;
  public function __construct()
  {
    $this->arc_model = new ArchivesModel();
    $this->cat_model = new CategoriesModel();
  }

  // Menampilkan list archives -> Start
  public function index()
  {
    $data = [
      'title'       => 'Master Arsip',
      'navbar'      => 'Master Arsip',
      'card'        => 'List Arsip',
      'archives'  => $this->arc_model
        ->join('categories', 'categories.kd_kategori = archives.kd_kategori')
        ->orderBy
        ->findAll()
    ];

    return view('archives_view/index', $data);
  }


  // Fitur tambah archives --> Start
  public function add()
  {
    $data = [
      'title'       => 'Tambah Arsip',
      'navbar'      => 'Master Arsip',
      'card'        => 'Form Tambah Arsip',
      'categories'  => $this->cat_model->findAll(),
      'validation'  => \Config\Services::validation()
    ];

    return view('archives_view/add', $data);
  }
  public function insert()
  {
    $getCatId = implode(",", $this->cat_model->findColumn('kd_kategori'));
    // Validasi input tambah folder
    $validate = [
      'cat_id' => [
        'rules' => 'required|in_list[' . $getCatId . ']',
        'errors' => [
          'in_list' => 'Kategori tidak terdaftar/tidak ada.'
        ]
      ],
      'archive_name' => [
        'rules' => 'required|alpha_numeric_space|is_unique[archives.archive_name]',
        'errors' => [
          'required' => 'Mohon isi kolom nama folder.',
          'alpha_numeric_space' => 'Yang anda masukkan bukan karakter alfabet, numerik dan spasi.',
          'is_unique' => 'Nama menu sudah terdaftar.'
        ]
      ],
      'archive_file' => [
        'rules' => 'max_size[archive_file,5120]|mime_in[archive_file,application/pdf]',
        'errors' => [
          'max_size' => 'Ukuran file melebihi 5Mb.',
          'mime_in' => 'File yang diunggah bukan pdf.'
        ]
      ],
    ];
    if (!$this->validate($validate)) {
      return redirect()->to(base_url('/arsip/tambah'))->withInput();
    }

    // HTMLSpecialChars
    $postCatId = htmlspecialchars($this->request->getVar('cat_id'));
    $postArsip = htmlspecialchars($this->request->getVar('archive_name'));
    $postFile = $this->request->getFile('archive_file');

    $get_randname = $postFile->getRandomName();
    $get_mime = $postFile->getMimeType();
    $get_ext = $postFile->guessExtension('mb');
    $get_size = $postFile->getSizeByUnit();

    // Upload File
    if ($postFile->getError() == 4) {
      $msg = "Mohon unggah file terlebih dahulu.";
      flashAlert('danger', $msg);
      redirect()->to(base_url('arsip/tambah'));
    } else {
      // Buat direktori jika belum ada
      if (!is_dir('archives')) {
        mkdir('/archives', 0777, TRUE);
      }
      // Pindahkan file ke folder img menggunakan move()
      $postFile->move('archives/', $get_randname);

      $this->arc_model->save([
        'cat_id' => $postCatId,
        'archive_name' => $postArsip,
        'file_name' => $get_randname,
        'file_ext' => $get_ext,
        'file_size' => $get_size,
        'mime_type' => $get_mime,
      ]);
      $msg = "Anda berhasil menambah arsip " . $postArsip . ".";
      flashAlert('success', $msg);
    }
    return redirect()->to(base_url('/arsip'));
  }


  // Fitur ubah archives --> Start
  public function edit($id)
  {
    $data = [
      'title'       => 'Edit Arsip',
      'navbar'      => 'Master Arsip',
      'card'        => 'Form Edit Arsip',
      'archives'    => $this->arc_model->find($id),
      'categories'  => $this->cat_model->findAll(),
      'validation'  => \Config\Services::validation()
    ];

    return view('archives_view/edit', $data);
  }
  public function update($id)
  {
    // HTMLSpecialChars
    $postCatId = htmlspecialchars($this->request->getVar('cat_id'));
    $postArsip = htmlspecialchars($this->request->getVar('archive_name'));
    $postFile = $this->request->getFile('archive_file');

    $getArc = $this->arc_model->find($id);
    // Rule nama arsip
    if ($postArsip != $getArc['archive_name']) {
      $ruleName = 'required|alpha_numeric_space|is_unique[archives.archive_name]';
    } else {
      $ruleName = 'required|alpha_numeric_space';
    }

    $getCatId = implode(",", $this->cat_model->findColumn('id'));
    // Validasi input tambah folder
    $validate = [
      'cat_id' => [
        'rules' => 'required|in_list[' . $getCatId . ']',
        'errors' => [
          'in_list' => 'Kategori tidak terdaftar/tidak ada.'
        ]
      ],
      'archive_name' => [
        'rules' => $ruleName,
        'errors' => [
          'required' => 'Mohon isi kolom nama folder.',
          'alpha_numeric_space' => 'Yang anda masukkan bukan karakter alfabet, numerik dan spasi.',
          'is_unique' => 'Nama menu sudah terdaftar.'
        ]
      ],
      'archive_file' => [
        'rules' => 'max_size[archive_file,5120]|mime_in[archive_file,application/pdf]',
        'errors' => [
          'max_size' => 'Ukuran file melebihi 5Mb.',
          'mime_in' => 'File yang diunggah bukan pdf.'
        ]
      ],
    ];
    if (!$this->validate($validate)) {
      return redirect()->to(base_url('/arsip/edit' . $id))->withInput();
    }


    // Upload File
    if ($postFile->getError() == 4) {
      $file_name = $getArc['file_name'];
      $get_mime = $getArc['mime_type'];
      $get_ext = $getArc['file_ext'];
      $get_size = $getArc['file_size'];
    } else {
      // Buat direktori jika belum ada
      if (!is_dir('archives')) {
        mkdir('/archives', 0777, TRUE);
      }
      $file_name = $postFile->getRandomName();
      $get_mime = $postFile->getMimeType();
      $get_ext = $postFile->guessExtension('mb');
      $get_size = $postFile->getSizeByUnit();

      // Pindahkan file ke folder img menggunakan move()
      $postFile->move('archives/', $file_name);
    }

    $this->arc_model->save([
      'id' => $id,
      'cat_id' => $postCatId,
      'archive_name' => $postArsip,
      'file_name' => $file_name,
      'file_ext' => $get_ext,
      'file_size' => $get_size,
      'mime_type' => $get_mime,
    ]);

    $msg = "Anda berhasil memperbarui arsip " . $postArsip . ".";
    flashAlert('success', $msg);
    return redirect()->to(base_url('/arsip'));
  }


  // Fitur Delete Folder --> Start
  public function delete($id)
  {
    $getArc = $this->arc_model->find($id);

    $path = "archives/" . $getArc['file_name'];
    $file = new \CodeIgniter\Files\File($path);
    $file->move('archives/terhapus/');

    $this->arc_model->delete($id);
    $msg = "Anda berhasil menghapus arsip " . $getArc['archive_name'] . ".";
    flashAlert('success', $msg);
    return redirect()->to(base_url('/arsip'));
  }


  // Fitur Tampil Arsip Terhapus --> Start
  public function show_all_deleted()
  {
    $data = [
      'title'        => 'Arsip Terhapus',
      'navbar'       => 'Master Arsip',
      'card'         => 'List Arsip Terhapus',
      'archives'     => $this->arc_model->onlyDeleted()->findAll(),
    ];
    return view('archives_view/deleted', $data);
  }


  // Fitur Restore Arsip Terhapus --> Start
  public function restore_one($id)
  {
    $this->arc_model->save(['id' => $id, 'deleted_at' => null]);

    $getArc = $this->arc_model->find($id);

    $path = "archives/terhapus/" . $getArc['file_name'];
    $file = new \CodeIgniter\Files\File($path);
    $file->move('archives/');

    $msg = "Berhasil mengembalikan " . $getArc['archive_name'] . ".";
    flashAlert('success', $msg);
    return redirect()->to(base_url('arsip/terhapus'));
  }


  // Fitur RestoreAll Arsip Terhapus --> Start
  public function restore_all()
  {
    // Ambil semua data yang terhapus dulu
    $getDelArc = $this->arc_model->onlyDeleted()->findAll();
    // Perulangan move file
    foreach ($getDelArc as $del) {
      $path = "archives/terhapus/" . $del['file_name'];
      $file = new \CodeIgniter\Files\File($path);
      $file->move('archives/');
    }

    $this->arc_model
      ->set(['deleted_at' => null])
      ->update();

    $msg = "Berhasil mengembalikan semua arsip yang terhapus.";
    flashAlert('success', $msg);
    return redirect()->to(base_url('arsip/terhapus'));
  }

  public function permanent_delete_all()
  {

    // Ambil semua data yang terhapus dulu
    $getDelArc = $this->arc_model->onlyDeleted()->findAll();
    // Perulangan move file
    foreach ($getDelArc as $del) {
      $path = "archives/terhapus/" . $del['file_name'];
      // Unlink file
      unlink($path);
      $this->arc_model->purgeDeleted();

      $msg = "Berhasil menghapus permanen semua arsip yang terhapus.";
      flashAlert('success', $msg);
    }

    return redirect()->to(base_url('/arsip/terhapus'));
  }

  public function permanent_delete_one($id)
  {
    $getArc = $this->arc_model->onlyDeleted()->find($id);
    $msg = "Berhasil menghapus permanen " . $getArc['archive_name'] . " yang terhapus.";

    // File mana yang ingin dihapus
    $path = "archives/terhapus/" . $getArc['file_name'];
    // Unlink file
    unlink($path);

    $this->arc_model->where('id', $id)->purgeDeleted();

    flashAlert('success', $msg);
    return redirect()->to(base_url('/arsip/terhapus'));
  }
}
