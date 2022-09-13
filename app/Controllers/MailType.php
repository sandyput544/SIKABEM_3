<?php

namespace App\Controllers;

class MailType extends BaseController
{
  protected $mailtype;
  public function __construct()
  {
    helper('bem');
    $this->mailtype = new \App\Models\MailTypeModel();
  }

  // Fitur tampil data
  public function index()
  {
    $data = [
      'title'       => 'Master Jenis Surat Keluar',
      'navbar'      => 'Surat Keluar',
      'card'        => 'List Jenis Surat Keluar',
      'mailtype'    => $this->mailtype->findAll()
    ];

    return view('mailtype_v/index', $data);
  }

  // Fitur tambah
  public function add()
  {
    $data = [
      'title'       => 'Tambah Jenis Surat Keluar',
      'navbar'      => 'Surat Keluar',
      'card'        => 'Form Tambah Jenis Surat Keluar',
      'validation'  => \Config\Services::validation()
    ];

    return view('mailtype_v/add', $data);
  }

  public function insert()
  {
    $postNama = htmlspecialchars($this->request->getVar('nama_jenis'));
    $postKode = htmlspecialchars($this->request->getVar('kode_surat'));

    $validate = [
      'nama_jenis' => [
        'rules' => 'required|alpha_space|is_unique[mail_type.nama_jenis]',
        'errors' => [
          'required' => 'Mohon isi kolom nama jenis surat',
          'alpha_space' => 'Yang anda masukkan bukan karakter alfabet dan spasi',
          'is_unique' => 'Nama jenis surat sudah terdaftar',
        ]
      ],
      'kode_surat' => [
        'rules' => 'required|alpha|is_unique[mail_type.kode_surat]',
        'errors' => [
          'required' => 'Mohon isi kolom kode surat',
          'alpha' => 'Yang anda masukkan bukan karakter alfabet',
          'is_unique' => 'Kode surat sudah terdaftar',
        ]
      ]
    ];

    if (!$this->validate($validate)) {
      return redirect()->to(base_url('jenis-surat/tambah'))->withInput();
    } else {
      $this->mailtype->save([
        'nama_jenis' => $postNama,
        'kode_surat' => $postKode
      ]);

      $msg = 'Berhasil menambah jenis surat.';
      flashAlert('success', $msg);
      return redirect()->to(base_url('jenis-surat'));
    }
  }

  // Fitur ubah
  public function edit($id)
  {
    $data = [
      'title'       => 'Ubah Jenis Surat Keluar',
      'navbar'      => 'Surat Keluar',
      'card'        => 'Form Ubah Jenis Surat Keluar',
      'mt'          => $this->mailtype->find($id),
      'validation'  => \Config\Services::validation()
    ];

    return view('mailtype_v/edit', $data);
  }

  public function update($id)
  {
    $getMType = $this->mailtype->find($id);

    $postNama = htmlspecialchars($this->request->getVar('nama_jenis'));
    $postKode = htmlspecialchars($this->request->getVar('kode_surat'));

    if ($postNama == $getMType['nama_jenis']) {
      $rName = 'required|alpha_space';
    } else {
      $rName = 'required|alpha_space|is_unique[mail_type.nama_jenis]';
    }

    if ($postKode == $getMType['kode_surat']) {
      $rKode = 'required|alpha_space';
    } else {
      $rKode = 'required|alpha_space|is_unique[mail_type.kode_surat]';
    }

    $validate = [
      'nama_jenis' => [
        'rules' => $rName,
        'errors' => [
          'required' => 'Mohon isi kolom nama jenis surat',
          'alpha_space' => 'Yang anda masukkan bukan karakter alfabet dan spasi',
          'is_unique' => 'Nama jenis surat sudah terdaftar',
        ]
      ],
      'kode_surat' => [
        'rules' => $rKode,
        'errors' => [
          'required' => 'Mohon isi kolom kode surat',
          'alpha' => 'Yang anda masukkan bukan karakter alfabet',
          'is_unique' => 'Kode surat sudah terdaftar',
        ]
      ]
    ];

    if (!$this->validate($validate)) {
      return redirect()->to(base_url('jenis-surat/edit/' . $id))->withInput();
    } else {
      $this->mailtype->save([
        'kd_jenissurat' => $id,
        'nama_jenis' => $postNama,
        'kode_surat' => $postKode
      ]);

      $msg = 'Berhasil mengubah jenis surat.';
      flashAlert('success', $msg);
      return redirect()->to(base_url('jenis-surat'));
    }
  }

  // Fitur hapus
  public function delete($id)
  {
    $getMType = $this->mailtype->find($id);
    $msg = "Berhasil menghapus data jenis surat : " . $getMType['nama_jenis'];
    flashAlert('success', $msg);
    $this->mailtype->delete($id);

    return redirect()->to(base_url('jenis-surat'));
  }

  // Fitur tampil data yang terhapus
  public function show_all_deleted()
  {
    $data = [
      'title'   => 'Jenis Surat Terhapus',
      'navbar'  => 'Surat Keluar',
      'card'    => 'List Jenis Surat Keluar Yang Terhapus',
      'mt'      => $this->mailtype->onlyDeleted()->findAll()
    ];

    return view('mailtype_v/deleted', $data);
  }

  // Fitur pulihkan semua
  public function restore_all()
  {
    $this->mailtype->set(['deleted_at' => null])->update();

    $msg = "Berhasil memulihkan semua data jenis surat yang terhapus.";
    flashAlert('success', $msg);
    return redirect()->to(base_url('jenis-surat/terhapus'));
  }

  // Fitur pulihkan satu
  public function restore_one($id)
  {
    $getMType = $this->mailtype->onlyDeleted()->find($id);
    $this->mailtype->save([
      'kd_jenissurat' => $id,
      'deleted_at' => null
    ]);

    $msg = "Berhasil memulihkan data jenis surat : " . $getMType['nama_jenis'] . ".";
    flashAlert('success', $msg);
    return redirect()->to(base_url('jenis-surat/terhapus'));
  }

  // Fitur hapus permanen semua
  public function permanent_delete_all()
  {
    $this->mailtype->purgeDeleted();

    $msg = "Berhasil menghapus permanen semua data jenis surat yang terhapus.";
    flashAlert('success', $msg);
    return redirect()->to(base_url('jenis-surat/terhapus'));
  }

  // Fitur hapus permanen satu
  public function permanent_delete_one($id)
  {
    $getMType = $this->mailtype->onlyDeleted()->find($id);
    $msg = "Berhasil menghapus permanen data jenis surat : " . $getMType['nama_jenis'] . ".";

    $this->mailtype->where('kd_jenissurat', $id)->purgeDeleted();

    flashAlert('success', $msg);
    return redirect()->to(base_url('jenis-surat/terhapus'));
  }
}
