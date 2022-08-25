<?php

namespace App\Controllers;

use App\Models\PositionsModel;
use App\Models\UsersModel;
use App\Models\UserPositionModel;

class Users extends BaseController
{
  protected $users_model;
  protected $positions_model;
  protected $user_pos_model;
  public function __construct()
  {
    helper('bem');
    $this->users_model = new UsersModel();
    $this->positions_model = new PositionsModel();
    $this->user_pos_model = new UserPositionModel();
  }

  public function index()
  {
    $data = [
      'title'         => 'Master User',
      'navbar'        => 'Master User',
      'card'          => 'List User',
      'users'         => $this->users_model
        ->findAll(),
    ];
    return view('users/index', $data);
  }

  // Tambah Start
  public function add()
  {
    $data = [
      'title'             => 'Tambah User',
      'navbar'            => 'Master User',
      'card'              => 'Form Tambah User',
      'positions'         => $this->positions_model
        ->where('is_active', 1)
        ->findAll(),
      'validation'        => \Config\Services::validation()
    ];
    return view('users/add', $data);
  }

  public function insert()
  {
    $postFname = htmlspecialchars($this->request->getVar('full_name'));
    $postGender = htmlspecialchars($this->request->getVar('gender'));
    $postPhone = htmlspecialchars($this->request->getVar('phone'));
    $postEmail = htmlspecialchars($this->request->getVar('email'));
    $postPassword = htmlspecialchars($this->request->getVar('password1'));
    $postPasswordHash = password_hash($postPassword, PASSWORD_DEFAULT);
    $postPosId = htmlspecialchars($this->request->getVar('pos_id'));

    $showPosId = implode(",", $this->positions_model->where('is_active', 1)->findColumn('id'));

    $validate = [
      'full_name' => [
        'rules'     => 'required|max_length[100]|alpha_space',
        'errors'    => [
          'required'      => 'Mohon isi kolom nama lengkap.',
          'max_length'    => 'Mohon isi kolom nama lengkap maksimal 100 karakter.',
          'alpha_space'   => 'Yang anda masukkan bukan karakter alfabet dan spasi.'
        ]
      ],
      'gender' => [
        'rules' => 'in_list[Pria,Wanita]',
        'errors' => [
          'in_list' => 'Pilihan tidak terdaftar.'
        ]
      ],
      'phone' => [
        'rules' => 'permit_empty|numeric',
        'errors' => [
          'numeric' => 'Yang anda masukkan bukan karakter numerik.',
        ]
      ],
      'email' => [
        'rules'     => 'required|valid_email|is_unique[users.email]',
        'errors'    => [
          'required'      => 'Mohon isi kolom email.',
          'valid_email'   => 'Email tidak valid.',
          'is_unique'     => 'Email sudah terdaftar.'
        ]
      ],
      'password1' => [
        'rules'   => 'required|min_length[5]|matches[password2]',
        'errors'  => [
          'required'    => 'Mohon isi kolom password.',
          'min_length'  => 'Mohon isi kolom password minimal panjang 5 karakter.',
          'matches'     => 'Password tidak cocok.'
        ]
      ],
      'password2' => [
        'rules'   => 'required',
        'errors'  => [
          'required'    => 'Mohon isi kolom konfirmasi password.',
        ]
      ],
      'pos_id' => [
        'rules' => 'in_list[0,' . $showPosId . ']',
        'errors' => [
          'in_list' => 'Pilihan tidak terdaftar.'
        ]
      ]
    ];

    if (!$this->validate($validate)) {
      return redirect()->to(base_url('/user/tambah'))->withInput();
    }

    $this->users_model->save([
      'full_name'        => $postFname,
      'gender'          => $postGender,
      'phone'           => $postPhone,
      'email'           => $postEmail,
      'password'        => $postPassword,
      'password_hash'   => $postPasswordHash,
      'photo'           => 'default.svg',
      'is_active'       => '1',
    ]);

    // Ambil id dengan full_name
    $getUser = $this->users_model->where('full_name', $postFname)->first();

    // Cek apakah pos_id != 0
    if ($postPosId != "0") {
      $this->user_pos_model->save([
        'user_id' => $getUser['id'],
        'pos_id' => $postPosId
      ]);
    }

    $msg = 'Berhasil menambahkan user ' . $postFname . '.';
    flashAlert('success', $msg);
    return redirect()->to(base_url() . '/user');
  }
  // Tambah End

  // Edit Start
  public function edit($id)
  {
    $getUser = $this->users_model
      ->join('user_position', 'user_position.user_id = users.id')
      ->find($id);

    $data = [
      'title'             => 'Edit User',
      'navbar'            => 'Master User',
      'card'              => 'Form Edit User',
      'user'              => $getUser,
      'positions'         => $this->positions_model
        ->where('is_active', 1)
        ->findAll(),
      'validation'        => \Config\Services::validation()
    ];
    return view('users/edit', $data);
  }

  public function update($id)
  {
    // Get User
    $getUser = $this->users_model->find($id);

    $postFname = htmlspecialchars($this->request->getVar('full_name'));
    $postGender = htmlspecialchars($this->request->getVar('gender'));
    $postPhone = htmlspecialchars($this->request->getVar('phone'));
    $postEmail = htmlspecialchars($this->request->getVar('email'));
    $postPassword = htmlspecialchars($this->request->getVar('password1'));
    $postPassword2 = htmlspecialchars($this->request->getVar('password2'));
    $postPosId = htmlspecialchars($this->request->getVar('pos_id'));
    $postActive = htmlspecialchars($this->request->getVar('is_active'));


    $showPosId = implode(",", $this->positions_model->where('is_active', 1)->findColumn('id'));

    /* Cek apakah password yang dimasukkan itu sama dengan password yang ada di tabel
    * Kalau sama maka perbolehkan untuk mengosongkan kolom password dan konfirmasi password
    */
    if ($postPassword == $getUser['password'] && $postPassword2 == null) {
      $pass1 = 'permit_empty';
      $pass2 = 'permit_empty';
    } else {
      $pass1 = 'required|min_length[5]|matches[password2]';
      $pass2 = 'required';
    }

    // Cek email = getUserEmail
    if ($postEmail == $getUser['email']) {
      $ruleEmail = 'required|valid_email';
    } else {
      $ruleEmail = 'required|valid_email|is_unique[users.email]';
    }

    $validate = [
      'full_name' => [
        'rules'     => 'required|max_length[100]|alpha_space',
        'errors'    => [
          'required'      => 'Mohon isi kolom nama lengkap.',
          'max_length'    => 'Mohon isi kolom nama lengkap maksimal 100 karakter.',
          'alpha_space'   => 'Yang anda masukkan bukan karakter alfabet dan spasi.'
        ]
      ],
      'gender' => [
        'rules' => 'in_list[Pria,Wanita]',
        'errors' => [
          'in_list' => 'Pilihan tidak terdaftar.'
        ]
      ],
      'phone' => [
        'rules' => 'permit_empty|numeric',
        'errors' => [
          'numeric' => 'Yang anda masukkan bukan karakter numerik.',
        ]
      ],
      'email' => [
        'rules'     => $ruleEmail,
        'errors'    => [
          'required'      => 'Mohon isi kolom email.',
          'valid_email'   => 'Email tidak valid.',
          'is_unique'     => 'Email sudah terdaftar.'
        ]
      ],
      'password1' => [
        'rules'   => $pass1,
        'errors'  => [
          'required'    => 'Mohon isi kolom password.',
          'min_length'  => 'Mohon isi kolom password minimal panjang 5 karakter.',
          'matches'     => 'Password tidak cocok.'
        ]
      ],
      'password2' => [
        'rules'   => $pass2,
        'errors'  => [
          'required'    => 'Mohon isi kolom konfirmasi password.',
        ]
      ],
      'pos_id' => [
        'rules' => 'in_list[0,' . $showPosId . ']',
        'errors' => [
          'in_list' => 'Pilihan tidak terdaftar.'
        ]
      ]
    ];

    if (!$this->validate($validate)) {
      return redirect()->to(base_url('/user/edit/' . $id))->withInput();
    }

    $postPasswordHash = password_hash($postPassword, PASSWORD_DEFAULT);

    $this->users_model->save([
      'id'              => $id,
      'full_name'       => $postFname,
      'gender'          => $postGender,
      'phone'           => $postPhone,
      'email'           => $postEmail,
      'password'        => $postPassword,
      'password_hash'   => $postPasswordHash,
      'is_active'       => $postActive
    ]);

    // Ambil id dengan full_name
    $getUser = $this->users_model->where('full_name', $postFname)->first();

    // Cek apakah pos_id != 0
    if ($postPosId != "0") {
      // Ambil data posisi user, lalu cek apakah jumlah kolom data lebih dari 0
      $get_pos = $this->user_pos_model
        ->where(['user_id' => $id])
        ->get();

      if ($get_pos->getNumRows() < 1) {
        $this->user_pos_model->save([
          'user_id' => $id,
          'pos_id' => $postPosId
        ]);
      } else {
        $this->user_pos_model
          ->where('user_id', $id)
          ->set('pos_id', $postPosId)
          ->update();
      }
    }

    $msg = 'Berhasil memperbarui data user ' . $postFname . '.';
    flashAlert('success', $msg);
    return redirect()->to(base_url() . '/user');
  }
  // Edit End

  // Hapus Start
  public function delete($id)
  {
    // Set is_active menjadi 0
    $this->users_model->save(['id' => $id, 'is_active' => 0]);
    // Ambil data user
    $getUser = $this->users_model->find($id);
    $msg = 'Berhasil menghapus ' . $getUser['full_name'] . '.';

    // Delete Data Member
    $this->users_model->delete($id);

    flashAlert('success', $msg);
    return redirect()->to(base_url('/user'));
  }
  // Hapus End

  // Detail
  public function detail($id)
  {
    $getUser = $this->users_model
      ->join('user_position', 'user_position.user_id = users.id')
      ->join('positions', 'positions.id = user_position.pos_id')
      ->find($id);
    $time = new \CodeIgniter\I18n\Time($getUser['created_at']);

    $data = [
      'title'             => 'Detail User',
      'navbar'            => 'Master User',
      'card'              => 'Profil ' . $getUser['full_name'],
      'user'              => $getUser,
      'created_date'      => $time
    ];

    return view('users/detail', $data);
  }

  // Deleted Page Start
  public function show_all_deleted()
  {
    $getUser = $this->users_model
      ->join('user_position', 'user_position.user_id = users.id')
      ->join('positions', 'positions.id = user_position.pos_id')
      ->onlyDeleted()
      ->findAll();

    $data = [
      'title'             => 'User Terhapus',
      'navbar'            => 'Master User',
      'card'              => 'List User Terhapus',
      'users'             => $getUser,
    ];

    return view('users/deleted', $data);
  }

  public function restore_one($id)
  {
    $this->users_model->where('id', $id)->set('deleted_at', null)->update();
    $getUsers = $this->users_model->find($id);

    $msg = 'Berhasil mengembalikan ' . $getUsers['full_name'] . '.';
    flashAlert('success', $msg);
    return redirect()->to(base_url('user/terhapus'));
  }

  public function restore_all()
  {
    $this->users_model->set(['deleted_at' => null])->update();

    $msg = 'Berhasil mengembalikan semua user yang terhapus.';
    flashAlert('success', $msg);
    return redirect()->to(base_url('user/terhapus'));
  }

  public function permanent_delete_all()
  {
    // Hapus semua posisi user dari tabel user_position
    // Ambil semua data yang terhapus
    $getDeleted = $this->users_model->onlyDeleted()->findAll();
    // Lakukan foreach/loop untuk menghapus data
    foreach ($getDeleted as $del) {
      $this->user_pos_model->where('user_id', $del['id'])->delete();
    }

    $this->users_model->purgeDeleted();

    flashAlert('success', 'Berhasil menghapus permanen semua data user yang terhapus. Semua data user tersebut yang dihapus permanen tidak dapat dipulihkan.');
    return redirect()->to(base_url('user/terhapus'));
  }

  public function permanent_delete_one($id)
  {
    // ambil data user
    $getName = $this->users_model->onlyDeleted()->find($id);
    $msg = "Berhasil menghapus user " . $getName['full_name'] . " secara permanen. Data user yang dihapus permanen tidak dapat dipulihkan.";

    $this->user_pos_model->where('user_id', $id)->delete();

    $this->users_model->where('id', $id)->purgeDeleted();

    flashAlert('success', $msg);
    return redirect()->to(base_url('user/terhapus'));
  }
  // Deleted Page End
}
