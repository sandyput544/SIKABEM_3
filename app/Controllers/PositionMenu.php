<?php

namespace App\Controllers;

use App\Models\PositionsModel;
use App\Models\MenusModel;
use App\Models\PositionMenuModel;
use App\Controllers\BaseController;

class PositionMenu extends BaseController
{
  protected $positions_model;
  protected $menus_model;
  protected $pos_menu_model;
  public function __construct()
  {
    $this->positions_model = new PositionsModel();
    $this->menus_model = new MenusModel();
    $this->pos_menu_model = new PositionMenuModel();
  }

  // Menampilkan list 
  public function index()
  {
    $id = $this->request->uri->getSegment(3);
    // Ambil data posisi dan menu
    $getPos = $this->positions_model->find($id);

    $getMenus = $this->menus_model->where('menu_active', 1)->findAll();
    $data = [
      'title'     => 'List Akses Menu ' . $getPos['nama_jbt'],
      'card'      => 'List Akses Menu ' . $getPos['nama_jbt'],
      'navbar'    => 'Master Jabatan',
      'menus'     => $getMenus,
      'kd_jabatan' => $id
    ];
    return view('positions/menu-akses', $data);
  }

  // Simpan Akses
  public function post_access()
  {
    $kd_jabatan = $this->request->getVar('kd_jabatan');
    $kd_menu = $this->request->getVar('kd_menu');

    $data = [
      'kd_jabatan' => $kd_jabatan,
      'kd_menu' => $kd_menu
    ];

    $getPosMenu = $this->pos_menu_model->where($data)->get();
    $getPos = $this->positions_model->find($kd_jabatan);
    $getMenu = $this->menus_model->find($kd_menu);

    // Cek apakah numrows < 1 | numrows > 0
    if ($getPosMenu->getNumRows() < 1) {
      $msg = "Berhasil memberi " . $getPos['nama_jbt'] . " akses ke " . $getMenu['nama_menu'] . ".";
      $this->pos_menu_model->save($data);
    } else {
      $msg = "Berhasil menghapus akses " . $getPos['nama_jbt'] . " ke " . $getMenu['nama_menu'] . ".";
      $this->pos_menu_model->where($data)->delete();
    }

    flashAlert('success', $msg);
  }
}
