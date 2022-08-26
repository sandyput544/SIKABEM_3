<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Collection extends BaseController
{
  protected $cat_model;
  protected $arc_model;
  public function __construct()
  {
    $this->cat_model = new \App\Models\CategoriesModel();
    $this->arc_model = new \App\Models\ArchivesModel();
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
    $getArc = $this->arc_model->where('nama_file', $nama_file)->first();
    $getCat = $this->cat_model->find($getArc['kd_kategori']);

    $data = [
      'title'       => 'Lihat Arsip',
      'navbar'      => 'Koleksi Arsip',
      'card'        => 'Detail Arsip',
      'nama_kat'    => $getCat['nama_kat'],
      'archives'    => $getArc,
    ];

    return view('collection/detail', $data);
  }

  public function download($nama_file)
  {
    // Ambil data arsip
    $getArc = $this->arc_model->where('nama_file', $nama_file)->first();

    $name = $getArc['nama_arsip'] . '.pdf';
    return $this->response->download('archives/' . $nama_file, null)->setFileName($name);
  }
}
