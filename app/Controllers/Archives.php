<?php

namespace App\Controllers;

use \App\Models\CategoriesModel;
use \App\Models\ArchivesModel;
use \App\Models\ArchivesAccessModel;
use \App\Models\UsersModel;

class Archives extends BaseController
{
  protected $arc_model;
  protected $cat_model;
  protected $acc_model;
  protected $user_model;
  public function __construct()
  {
    $this->arc_model = new ArchivesModel();
    $this->cat_model = new CategoriesModel();
    $this->acc_model = new ArchivesAccessModel();
    $this->user_model = new UsersModel();
  }

  // Menampilkan list archives -> Start
  public function index()
  {
    $data = [
      'title'       => 'Master Arsip',
      'navbar'      => 'Master Arsip',
      'card'        => 'List Arsip',
      'archives'  => $this->arc_model
        ->select('archives.kd_arsip AS kd_arsip, categories.nama_kat AS kategori, archives.nomor_arsip AS nomor_arsip, archives.nama_arsip AS nama_arsip, archives.nama_pembuat AS pembuat, archives.tgl_buat AS tgl_buat, archives.nama_file AS nama_file')
        ->join('categories', 'categories.kd_kategori = archives.kd_kategori')
        ->orderBy('kd_arsip', 'DESC')
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
      'kd_kategori' => [
        'rules' => 'required|in_list[' . $getCatId . ']',
        'errors' => [
          'in_list' => 'Kategori tidak terdaftar/tidak ada.'
        ]
      ],
      'nomor_arsip' => [
        'rules' => 'required|string|is_unique[archives.nama_arsip]',
        'errors' => [
          'required' => 'Mohon isi kolom nomor arsip.',
          'is_unique' => 'Nomor arsip sudah terdaftar.'
        ]
      ],
      'nama_arsip' => [
        'rules' => 'required|alpha_numeric_space|is_unique[archives.nama_arsip]',
        'errors' => [
          'required' => 'Mohon isi kolom nama arsip.',
          'alpha_numeric_space' => 'Yang anda masukkan bukan karakter alfabet, numerik dan spasi.',
          'is_unique' => 'Nama arsip sudah terdaftar.'
        ]
      ],
      'tgl_buat' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Mohon isi kolom nama pembuat arsip.',
        ]
      ],
      'nama_pembuat' => [
        'rules' => 'required|alpha_space',
        'errors' => [
          'required' => 'Mohon isi kolom nama pembuat arsip.',
          'alpha_numeric_space' => 'Yang anda masukkan bukan karakter alfabet dan spasi.',
        ]
      ],
      'file_arsip' => [
        'rules' => 'max_size[file_arsip,5120]|mime_in[file_arsip,application/pdf]',
        'errors' => [
          'max_size' => 'Ukuran file melebihi 5Mb.',
          'mime_in' => 'File yang diunggah bukan pdf.'
        ]
      ],
    ];
    if (!$this->validate($validate)) {
      return redirect()->to(base_url('arsip/tambah'))->withInput();
    } else {
      // HTMLSpecialChars
      $postKategori = htmlspecialchars($this->request->getVar('kd_kategori'));
      $postNoArsip = htmlspecialchars($this->request->getVar('nomor_arsip'));
      $postNamaArsip = htmlspecialchars($this->request->getVar('nama_arsip'));
      $postCreatedDate = htmlspecialchars($this->request->getVar('tgl_buat'));
      $postNamaPembuat = htmlspecialchars($this->request->getVar('nama_pembuat'));
      $postFile = $this->request->getFile('file_arsip');

      $get_randname = $postFile->getRandomName();
      $get_mime = $postFile->getMimeType();
      $get_size = $postFile->getSizeByUnit('mb');

      // Upload File
      if ($postFile->getError() == 4) {
        $msg = "Mohon unggah file terlebih dahulu.";
        flashAlert('danger', $msg, 'bi-exclamation-circle-fill');
        return redirect()->to(base_url('/arsip/tambah'))->withInput();
      } else {
        // Buat direktori jika belum ada
        if (!is_dir('archives')) {
          mkdir('/archives', 0777, TRUE);
        }
        // Pindahkan file ke folder img menggunakan move()
        $postFile->move('archives/', $get_randname);

        $this->arc_model->save([
          'kd_kategori' => $postKategori,
          'nomor_arsip' => $postNoArsip,
          'nama_arsip' => $postNamaArsip,
          'tgl_buat' => $postCreatedDate,
          'nama_pembuat' => $postNamaPembuat,
          'id_uploader' => session('kd_user'),
          'id_contributor' => session('kd_user'),
          'nama_file' => $get_randname,
          'ukuran_file' => $get_size,
          'mime' => $get_mime,
        ]);
        $msg = "Anda berhasil menambah arsip " . $postNamaArsip . ".";
        flashAlert('success', $msg);
        return redirect()->to(base_url('/arsip'));
      }
    }
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
    $postKategori = htmlspecialchars($this->request->getVar('kd_kategori'));
    $postNoArsip = htmlspecialchars($this->request->getVar('nomor_arsip'));
    $postNamaArsip = htmlspecialchars($this->request->getVar('nama_arsip'));
    $postCreatedDate = htmlspecialchars($this->request->getVar('tgl_buat'));
    $postNamaPembuat = htmlspecialchars($this->request->getVar('nama_pembuat'));
    $postFile = $this->request->getFile('file_arsip');

    $getArc = $this->arc_model->find($id);
    // Rule nama arsip
    if ($postNamaArsip != $getArc['nama_arsip']) {
      $ruleName = 'required|alpha_numeric_space|is_unique[archives.nama_arsip]';
    } else {
      $ruleName = 'required|alpha_numeric_space';
    }
    if ($postNoArsip != $getArc['nomor_arsip']) {
      $ruleNo = 'required|string|is_unique[archives.nama_arsip]';
    } else {
      $ruleNo = 'required|string';
    }

    $getCatId = implode(",", $this->cat_model->findColumn('kd_kategori'));
    // Validasi input tambah folder
    $validate = [
      'kd_kategori' => [
        'rules' => 'required|in_list[' . $getCatId . ']',
        'errors' => [
          'in_list' => 'Kategori tidak terdaftar/tidak ada.'
        ]
      ],
      'nomor_arsip' => [
        'rules' => $ruleNo,
        'errors' => [
          'required' => 'Mohon isi kolom nomor arsip.',
          'is_unique' => 'Nomor arsip sudah terdaftar.'
        ]
      ],
      'nama_arsip' => [
        'rules' => $ruleName,
        'errors' => [
          'required' => 'Mohon isi kolom nama arsip.',
          'alpha_numeric_space' => 'Yang anda masukkan bukan karakter alfabet, numerik dan spasi.',
          'is_unique' => 'Nama arsip sudah terdaftar.'
        ]
      ],
      'tgl_buat' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Mohon isi kolom nama pembuat arsip.',
        ]
      ],
      'nama_pembuat' => [
        'rules' => 'required|alpha_space',
        'errors' => [
          'required' => 'Mohon isi kolom nama pembuat arsip.',
          'alpha_numeric_space' => 'Yang anda masukkan bukan karakter alfabet dan spasi.',
        ]
      ],
      'file_arsip' => [
        'rules' => 'max_size[file_arsip,5120]|mime_in[file_arsip,application/pdf]',
        'errors' => [
          'max_size' => 'Ukuran file melebihi 5Mb.',
          'mime_in' => 'File yang diunggah bukan pdf.'
        ]
      ],
    ];
    if (!$this->validate($validate)) {
      return redirect()->to(base_url('/arsip/edit' . $id))->withInput();
    } else {
      // Upload File
      if ($postFile->getError() == 4) {
        $file_name = $getArc['nama_file'];
        $get_mime = $getArc['mime'];
        $get_size = $getArc['ukuran_file'];
      } else {
        // Buat direktori jika belum ada
        if (!is_dir('archives')) {
          mkdir('/archives', 0777, TRUE);
        }
        $file_name = $getArc['nama_file'];
        $get_mime = $postFile->getMimeType();
        $get_size = $postFile->getSizeByUnit('mb');

        // Pindahkan file ke folder img menggunakan move()
        $postFile->move('archives/', $file_name);
      }

      $this->arc_model->save([
        'kd_arsip' => $id,
        'kd_kategori' => $postKategori,
        'nomor_arsip' => $postNoArsip,
        'nama_arsip' => $postNamaArsip,
        'tgl_buat' => $postCreatedDate,
        'nama_pembuat' => $postNamaPembuat,
        'nama_file' => $file_name,
        'ukuran_file' => $get_size,
        'mime' => $get_mime,
        'id_contributor' => session('kd_user'),
      ]);

      if ($postNamaArsip == $getArc['nama_arsip']) {
        $msg = "Anda berhasil memperbarui arsip : " . $getArc['nama_arsip'] . ".";
      } else {
        $msg = "Anda berhasil memperbarui arsip " . $getArc['nama_arsip'] . " <span class='bi-arrow-right'></span> " . $postNamaArsip . ".";
      }
      flashAlert('success', $msg);
      return redirect()->to(base_url('/arsip'));
    }
  }


  // Fitur Delete Folder --> Start
  public function delete($id)
  {
    $getArc = $this->arc_model->find($id);

    $path = "archives/" . $getArc['nama_file'];
    $file = new \CodeIgniter\Files\File($path);
    $file->move('archives/terhapus/');

    $this->arc_model->delete($id);
    $msg = "Anda berhasil menghapus arsip : " . $getArc['nama_arsip'] . ".";
    flashAlert('success', $msg);
    return redirect()->to(base_url('/arsip'));
  }

  public function detail($slug)
  {
    $getArc = $this->arc_model
      ->select('archives.kd_kategori AS kd_kategori, archives.kd_arsip AS kd_arsip, archives.nama_arsip AS nama_arsip, categories.nama_kat AS kategori, archives.nomor_arsip AS nomor_arsip, archives.nama_pembuat AS pembuat, archives.tgl_buat AS tgl_buat, archives.ukuran_file AS ukuran_file, archives.created_at AS pertama_up, archives.updated_at AS tgl_modif, archives.nama_file AS nama_file, archives.mime AS mime, archives.id_contributor AS id_contributor, archives.id_uploader AS id_uploader')
      ->join('categories', 'categories.kd_kategori = archives.kd_kategori')
      ->where('archives.nama_file = ', $slug)
      ->first();

    $nama_uploader = $this->user_model->find($getArc['id_uploader']);
    $nama_kontributor = $this->user_model->find($getArc['id_contributor']);

    $data = [
      'title'        => 'Detail Arsip',
      'navbar'       => 'Master Arsip',
      'accessing'    => 'List Akun Pengakses Arsip',
      'card'         => 'Detail Arsip',
      'nama_uploader' => $nama_uploader['nama_user'],
      'nama_kontributor' => $nama_kontributor['nama_user'],
      'archives'     => $getArc,
      'list_access'  => $this->acc_model
        ->select('archives_access.kd_arsip AS id_arsip, users.nama_user AS nama_user, positions.singkatan_jbt AS singkatan_jbt, archives_access.tgl_akses AS tgl_akses, archives_access.keterangan AS keterangan')
        ->join('users', 'users.kd_user = archives_access.kd_user', 'left')
        ->join('positions', 'positions.kd_jabatan = users.kd_jabatan', 'left')
        ->where('kd_arsip', $getArc['kd_arsip'])->findAll(),
    ];
    return view('archives_view/detail', $data);
  }

  // Fitur Tampil Arsip Terhapus --> Start
  public function show_all_deleted()
  {
    $data = [
      'title'        => 'Arsip Terhapus',
      'navbar'       => 'Master Arsip',
      'card'         => 'List Arsip Terhapus',
      'archives'     => $this->arc_model
        ->select('archives.kd_arsip AS kd_arsip, categories.nama_kat AS kategori, archives.nama_arsip AS nama_arsip, archives.nomor_arsip AS nomor_arsip, archives.nama_pembuat AS pembuat, archives.deleted_at AS tgl_delete')
        ->join('categories', 'categories.kd_kategori = archives.kd_kategori')
        ->onlyDeleted()
        ->findAll(),
    ];
    return view('archives_view/deleted', $data);
  }

  // Fitur Restore Arsip Terhapus --> Start
  public function restore_one($id)
  {
    $this->arc_model->save(['kd_arsip' => $id, 'deleted_at' => null]);

    $getArc = $this->arc_model->find($id);

    $path = "archives/terhapus/" . $getArc['nama_file'];
    $file = new \CodeIgniter\Files\File($path);
    $file->move('archives/');

    $msg = "Berhasil mengembalikan " . $getArc['nama_arsip'] . ".";
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
      $path = "archives/terhapus/" . $del['nama_file'];
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
      $path = "archives/terhapus/" . $del['nama_file'];
      // Unlink file
      unlink($path);
    }
    $this->arc_model->purgeDeleted();

    $msg = "Berhasil menghapus permanen semua arsip yang terhapus.";
    flashAlert('success', $msg);
    return redirect()->to(base_url('/arsip/terhapus'));
  }

  public function permanent_delete_one($id)
  {
    $getArc = $this->arc_model->onlyDeleted()->find($id);
    $msg = "Berhasil menghapus permanen " . $getArc['nama_arsip'] . " yang terhapus.";

    // File mana yang ingin dihapus
    $path = "archives/terhapus/" . $getArc['nama_file'];
    // Unlink file
    unlink($path);

    $this->arc_model->where('kd_arsip', $id)->purgeDeleted();

    flashAlert('success', $msg);
    return redirect()->to(base_url('/arsip/terhapus'));
  }
}
