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
        ->join('positions', 'positions.kd_jabatan = users.kd_jabatan', 'left')
        ->where('is_login != 1')
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
        ->where('jml_kursi != 0')
        ->where('jbt_active', 1)
        ->findAll(),
      'validation'        => \Config\Services::validation()
    ];
    return view('users/add', $data);
  }

  public function insert()
  {
    $postFname = htmlspecialchars($this->request->getVar('nama_user'));
    $postGender = htmlspecialchars($this->request->getVar('jk'));
    $postPhone = htmlspecialchars($this->request->getVar('no_hp'));
    $postEmail = htmlspecialchars($this->request->getVar('email'));
    $postPassword = htmlspecialchars($this->request->getVar('password1'));
    $postPasswordHash = password_hash($postPassword, PASSWORD_DEFAULT);
    $postKdJBT = htmlspecialchars($this->request->getVar('kd_jabatan'));

    $showPosId = implode(",", $this->positions_model->where('jbt_active', 1)->findColumn('kd_jabatan'));

    $validate = [
      'nama_user' => [
        'rules'     => 'required|max_length[100]|alpha_space',
        'errors'    => [
          'required'      => 'Mohon isi kolom nama lengkap.',
          'max_length'    => 'Mohon isi kolom nama lengkap maksimal 100 karakter.',
          'alpha_space'   => 'Yang anda masukkan bukan karakter alfabet dan spasi.'
        ]
      ],
      'jk' => [
        'rules' => 'in_list[Pria,Wanita]',
        'errors' => [
          'in_list' => 'Pilihan tidak terdaftar.'
        ]
      ],
      'no_hp' => [
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
      'kd_jabatan' => [
        'rules' => 'in_list[0,' . $showPosId . ']',
        'errors' => [
          'in_list' => 'Pilihan tidak terdaftar.'
        ]
      ]
    ];

    if (!$this->validate($validate)) {
      return redirect()->to(base_url('/user/tambah'))->withInput();
    } else {
      // cek apakah kd_jabatan yang baru dimasukkan = kd_jabatan yang lama
      if ($postKdJBT == '0') {
        $kd_jabatan = '0';
      } else {
        // Simpan seat baru
        $getnewSeat = $this->positions_model->find($postKdJBT);
        $newSeat = intval($getnewSeat['jml_kursi']) - 1;
        $this->positions_model->save([
          'kd_jabatan' => $postKdJBT,
          'jml_kursi' => $newSeat
        ]);
        $kd_jabatan = $postKdJBT;
      }

      $this->users_model->save([
        'nama_user'       => $postFname,
        'kd_jabatan'      => $kd_jabatan,
        'jk'              => $postGender,
        'no_hp'           => $postPhone,
        'email'           => $postEmail,
        'password'        => $postPassword,
        'password_hash'   => $postPasswordHash,
        'foto'            => 'default.svg',
        'user_active'     => '1',
        'is_login'        => '0',
      ]);

      $msg = 'Berhasil menambahkan user ' . $postFname . '.';
      flashAlert('success', $msg);
      return redirect()->to(base_url() . '/user');
    }
  }
  // Tambah End

  // Edit Start
  public function edit($id)
  {
    $getUser = $this->users_model
      ->find($id);

    $data = [
      'title'             => 'Edit User',
      'navbar'            => 'Master User',
      'card'              => 'Form Edit User',
      'user'              => $getUser,
      'positions'         => $this->positions_model
        ->where('jml_kursi != 0')
        ->where('jbt_active', 1)
        ->findAll(),
      'validation'        => \Config\Services::validation()
    ];
    return view('users/edit', $data);
  }

  public function update($id)
  {
    // Get User
    $getUser = $this->users_model->find($id);

    $postFname = htmlspecialchars($this->request->getVar('nama_user'));
    $postGender = htmlspecialchars($this->request->getVar('jk'));
    $postPhone = htmlspecialchars($this->request->getVar('no_hp'));
    $postEmail = htmlspecialchars($this->request->getVar('email'));
    $postPassword = htmlspecialchars($this->request->getVar('password1'));
    $postPassword2 = htmlspecialchars($this->request->getVar('password2'));
    $postKdJBT = htmlspecialchars($this->request->getVar('kd_jabatan'));
    $postuserActive = htmlspecialchars($this->request->getVar('user_active'));


    $showPosId = implode(",", $this->positions_model->where('jbt_active', 1)->findColumn('kd_jabatan'));

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
      'nama_user' => [
        'rules'     => 'required|max_length[100]|alpha_space',
        'errors'    => [
          'required'      => 'Mohon isi kolom nama lengkap.',
          'max_length'    => 'Mohon isi kolom nama lengkap maksimal 100 karakter.',
          'alpha_space'   => 'Yang anda masukkan bukan karakter alfabet dan spasi.'
        ]
      ],
      'jk' => [
        'rules' => 'in_list[Pria,Wanita]',
        'errors' => [
          'in_list' => 'Pilihan tidak terdaftar.'
        ]
      ],
      'no_hp' => [
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
      'kd_jabatan' => [
        'rules' => 'in_list[0,' . $showPosId . ']',
        'errors' => [
          'in_list' => 'Pilihan tidak terdaftar.'
        ]
      ]
    ];

    if (!$this->validate($validate)) {
      return redirect()->to(base_url('/user/edit/' . $id))->withInput();
    } else {
      // cek apakah kd_jabatan yang baru dimasukkan = kd_jabatan yang lama
      if ($postKdJBT == $getUser['kd_jabatan']) {
        $kd_jabatan = $getUser['kd_jabatan'];
      } elseif ($postKdJBT == '0') {
        // cek apakah kd jabatan sebelumnya bukan 0
        if ($getUser['kd_jabatan'] !== "0") {
          // Simpan seat lama
          $getoldSeat = $this->positions_model->find($getUser['kd_jabatan']);
          $oldSeat = intval($getoldSeat['jml_kursi']) + 1;
          $this->positions_model->save([
            'kd_jabatan' => $getoldSeat['kd_jabatan'],
            'jml_kursi' => $oldSeat
          ]);
        }
        $kd_jabatan = '0';
      } else {
        // cek apakah user tidak memiliki jabatan
        if ($getUser['kd_jabatan'] !== "0") {
          // Simpan seat lama
          $getoldSeat = $this->positions_model->find($getUser['kd_jabatan']);
          $oldSeat = intval($getoldSeat['jml_kursi']) + 1;
          $this->positions_model->save([
            'kd_jabatan' => $getoldSeat['kd_jabatan'],
            'jml_kursi' => $oldSeat
          ]);
        }

        // Simpan seat baru
        $getnewSeat = $this->positions_model->find($postKdJBT);
        $newSeat = intval($getnewSeat['jml_kursi']) - 1;
        $this->positions_model->save([
          'kd_jabatan' => $getnewSeat['kd_jabatan'],
          'jml_kursi' => $newSeat
        ]);
        $kd_jabatan = $postKdJBT;
      }

      $postPasswordHash = password_hash($postPassword, PASSWORD_DEFAULT);

      $this->users_model->save([
        'kd_user'         => $id,
        'kd_jabatan'      => $kd_jabatan,
        'nama_user'       => $postFname,
        'jk'              => $postGender,
        'no_hp'           => $postPhone,
        'email'           => $postEmail,
        'password'        => $postPassword,
        'password_hash'   => $postPasswordHash,
        'user_active'     => $postuserActive
      ]);

      $msg = 'Berhasil memperbarui data user ' . $postFname . '.';
      flashAlert('success', $msg);
      return redirect()->to(base_url() . '/user');
    }
  }
  // Edit End

  // Hapus Start
  public function delete($id)
  {
    // Set is_active menjadi 0
    $this->users_model->save(['kd_user' => $id, 'kd_jabatan' => 0, 'user_active' => 0]);
    // Ambil data user
    $getUser = $this->users_model->find($id);
    $msg = 'Berhasil menghapus ' . $getUser['nama_user'] . '.';

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
      ->join('positions', 'positions.kd_jabatan = users.kd_jabatan')->onlyDeleted()
      ->find($id);
    // $time = new \CodeIgniter\I18n\Time($getUser['created_at']);

    $data = [
      'title'             => 'Detail User',
      'navbar'            => 'Master User',
      'card'              => 'Profil ' . $getUser['nama_user'],
      'user'              => $getUser,
      // 'created_date'      => $time
    ];

    return view('users/detail', $data);
  }

  // Deleted Page Start
  public function show_all_deleted()
  {
    $getUser = $this->users_model
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
    $this->users_model->where('kd_user', $id)->set('deleted_at', null)->update();
    $getUsers = $this->users_model->find($id);

    $msg = 'Berhasil mengembalikan ' . $getUsers['nama_user'] . '.';
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
    $this->users_model->purgeDeleted();

    flashAlert('success', 'Berhasil menghapus permanen semua data user yang terhapus. Semua data user tersebut yang dihapus permanen tidak dapat dipulihkan.');
    return redirect()->to(base_url('user/terhapus'));
  }

  public function permanent_delete_one($id)
  {
    // ambil data user
    $getName = $this->users_model->onlyDeleted()->find($id);
    $msg = "Berhasil menghapus user " . $getName['nama_user'] . " secara permanen. Data user yang dihapus permanen tidak dapat dipulihkan.";

    $this->users_model->where('kd_user', $id)->purgeDeleted();

    flashAlert('success', $msg);
    return redirect()->to(base_url('user/terhapus'));
  }
  // Deleted Page End
}
