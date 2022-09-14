<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
  protected $user_model;
  protected $arc_model;
  protected $mail_model;
  public function __construct()
  {
    $this->arc_model = new \App\Models\ArchivesModel();
    $this->user_model = new \App\Models\UsersModel();
    $this->mail_model = new \App\Models\OutgoingMailModel();
  }

  public function index()
  {
    // Ambil total surat
    $totalMail = $this->mail_model->where(['deleted_at' => NULL])->countAllResults();
    // Ambil total arsip
    $totalArc = $this->arc_model->where(['deleted_at' => NULL])->countAllResults();
    // Ambil total User
    $totalUser = $this->user_model->where(['deleted_at' => NULL])->countAllResults();
    // Ambil total user nonaktif
    $totalNonActive = $this->user_model->where(['user_active' => 0])->countAllResults();

    // Ambil arsip
    $getLatestArc = $this->arc_model
      ->select('archives.kd_kategori AS kd_kategori, archives.kd_arsip AS kd_arsip, archives.nama_arsip AS nama_arsip, archives.nomor_arsip AS nomor_arsip, archives.nama_pembuat AS pembuat, archives.updated_at AS tgl_update')
      ->join('categories', 'categories.kd_kategori = archives.kd_kategori')
      ->orderBy('archives.kd_arsip', 'DESC')
      ->limit(10, 20)
      ->findAll();

    // Ambil jumlah user yang sedang login
    $getLoggedInUser = $this->user_model
      ->select('users.nama_user AS nama_user, users.kd_jabatan AS id_jbt, positions.nama_jbt AS jabatan, users.log_date AS log_date, users.is_login AS is_login')
      ->join('positions', 'positions.kd_jabatan = users.kd_jabatan')
      ->where('log_date !=', NULL)
      ->findAll();

    $data = [
      'title' => 'Dashboard',
      'navbar' => 'Dashboard',
      'card1' => 'Arsip Terbaru',
      'card2' => 'User Yang Sedang Login',
      'totalMail' => $totalMail,
      'totalArc' => $totalArc,
      'totalUser' => $totalUser,
      'totalNonActive' => $totalNonActive,
      'archives' => $getLatestArc,
      'users' => $getLoggedInUser
    ];

    return view('dashboard/index', $data);
  }
}
