<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;

class Collection extends BaseController
{
  protected $cat_model;
  protected $arc_model;
  protected $acc_model;
  public function __construct()
  {
    $this->cat_model = new \App\Models\CategoriesModel();
    $this->arc_model = new \App\Models\ArchivesModel();
    $this->acc_model = new \App\Models\ArchivesAccessModel();
  }

  public function index()
  {
    $data = [
      'title'       => 'Koleksi Arsip',
      'navbar'      => 'Koleksi Arsip',
      'card'        => 'List Koleksi Arsip',
      'archives'  => $this->arc_model
        ->join('categories', 'categories.kd_kategori = archives.kd_kategori')
        ->orderBy('categories.kd_kategori ASC, archives.kd_arsip DESC')
        ->findAll()
    ];

    return view('collection/index', $data);
  }

  public function detail($nama_file)
  {
    // $getArc = $this->arc_model
    //   ->join('categories', 'categories.kd_kategori = archives.kd_kategori')
    //   ->where('nama_file', $nama_file)->first();

    $getArc = $this->arc_model
      ->select('archives.kd_kategori AS kd_kategori, archives.kd_arsip AS kd_arsip, archives.nama_arsip AS nama_arsip, categories.nama_kat AS kategori, archives.nomor_arsip AS nomor_arsip, archives.nama_pembuat AS pembuat, archives.tgl_buat AS tgl_buat, archives.ukuran_file AS ukuran_file, archives.created_at AS pertama_up, archives.updated_at AS tgl_modif, archives.nama_file AS nama_file, archives.mime AS mime')
      ->join('categories', 'categories.kd_kategori = archives.kd_kategori')
      ->where('archives.nama_file = ', $nama_file)
      ->first();

    $data = [
      'title'       => 'Lihat Arsip',
      'navbar'      => 'Koleksi Arsip',
      'card'        => 'Detail Arsip',
      'archives'    => $getArc,
    ];

    // Simpan archives access
    $savedata = [
      'kd_arsip' => $getArc['kd_arsip'],
      'kd_user' => session('kd_user'),
      'tgl_akses' => new Time('now'),
      'keterangan' => 'Lihat'
    ];

    $this->acc_model->save($savedata);

    return view('collection/detail', $data);
  }

  public function download($nama_file)
  {
    // Ambil data arsip
    $getArc = $this->arc_model->where('nama_file', $nama_file)->first();

    // Simpan archives access
    $this->acc_model->save([
      'kd_arsip' => $getArc['kd_arsip'],
      'kd_user' => session('kd_user'),
      'tgl_akses' => new Time('now'),
      'keterangan' => 'Unduh'
    ]);

    $name = $getArc['nama_arsip'] . '.pdf';
    return $this->response->download('archives/' . $nama_file, null)->setFileName($name);
  }
}
