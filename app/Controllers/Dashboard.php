<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
  protected $user_model;
  protected $arc_model;
  public function __construct()
  {
    $this->arc_model = new \App\Models\ArchivesModel();
    $this->user_model = new \App\Models\UsersModel();
  }

  public function index()
  {
    $username = $this->membersModel->where(['member_id' => session()->get('member_id')])->first();
    $data = [
      'title' => 'Dashboard',
      'navbar' => 'Dashboard',
      'user' => $username
    ];

    return view('dashboard/index', $data);
  }
}
