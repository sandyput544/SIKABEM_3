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
      'card'        => 'List Kategori Arsip',
      'instance'    => $this->arc_model,
      'categories'  => $this->cat_model->findAll()
    ];

    return view('collection/index', $data);
  }

  public function getListArc($slug)
  {
    $getCat = $this->cat_model->where('slug', $slug)->first();

    $data = [
      'title'       => 'Koleksi Arsip',
      'navbar'      => 'Koleksi Arsip',
      'card'        => 'List Arsip ' . $getCat['cat_name'],
      'count'       => $this->arc_model->where(['cat_id' => $getCat['id']])->countAllResults(),
      'cat_id'      => $getCat['id'],
      'archives'  => $this->arc_model
        ->where(['cat_id' => $getCat['id']])
        ->findAll()
    ];

    return view('collection/list', $data);
  }

  public function detail($file_name)
  {
    $getArc = $this->arc_model
      ->where('file_name', $file_name)
      ->first();

    $getCat = $this->cat_model->find($getArc['cat_id']);

    $data = [
      'title'       => 'Lihat Arsip',
      'navbar'      => 'Koleksi Arsip',
      'card'        => 'Detail Arsip',
      'cat_name'    => $getCat['cat_name'],
      'archives'    => $getArc,
      'slug'        => $getCat['slug'],
    ];

    return view('collection/detail', $data);
  }

  public function download($file_name)
  {
    // Ambil data arsip
    $getArc = $this->arc_model->where('file_name', $file_name)->first();

    $name = $getArc['archive_name'] . '.pdf';
    return $this->response->download('archives/' . $file_name, null)->setFileName($name);
  }
}
