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
    $getMenus = $this->menus_model->where('is_active', 1)->findAll();
    $data = [
      'title'     => 'List Akses Menu ' . $getPos['pos_name'],
      'card'      => 'List Akses Menu ' . $getPos['pos_name'],
      'navbar'    => 'Master Posisi',
      'menus'     => $getMenus,
      'pos_id'    => $id
    ];
    return view('positions/menu-akses', $data);
  }

  // Simpan Akses
  public function post_access()
  {
    $pos_id = $this->request->getVar('posId');
    $menu_id = $this->request->getVar('menuId');

    $data = [
      'pos_id' => $pos_id,
      'menu_id' => $menu_id
    ];

    $getPosMenu = $this->pos_menu_model->where($data)->get();
    $getPos = $this->positions_model->find($pos_id);
    $getMenu = $this->menus_model->find($menu_id);

    // Cek apakah numrows < 1 | numrows > 0
    if ($getPosMenu->getNumRows() < 1) {
      $msg = "Berhasil memberi " . $getPos['pos_name'] . " akses ke " . $getMenu['menu_name'] . ".";
      $this->pos_menu_model->save($data);
    } else {
      $msg = "Berhasil menghapus akses " . $getPos['pos_name'] . " ke " . $getMenu['menu_name'] . ".";
      $this->pos_menu_model->where($data)->delete();
    }

    flashAlert('success', $msg);
  }
}
