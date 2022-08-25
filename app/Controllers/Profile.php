<?php

namespace App\Controllers;

use function PHPUnit\Framework\fileExists;

class Profile extends BaseController
{
  protected $time;
  protected $user_model;
  public function __construct()
  {
    helper('bem');
    $this->time = new \CodeIgniter\I18n\Time();
    $this->user_model = new \App\Models\UsersModel();
  }

  public function index()
  {
    $getuser = $this->user_model
      ->join('user_position', 'user_position.user_id = users.id')
      ->join('positions', 'positions.id = user_position.pos_id')
      ->where('email',  session('email'))
      ->first();

    $data = [
      'title' => 'Profil Saya',
      'navbar' => 'Profil Saya',
      'card' => 'Profil Saya',
      'user' => $getuser,
      'validation' => \Config\Services::validation(),
    ];

    return view('profile/index', $data);
  }

  public function edit_page()
  {
    $data = [
      'title' => 'Edit Profil',
      'navbar' => 'Profil Saya',
      'user' => $this->user_model->where('email',  session('email'))->first(),
      'validation' => \Config\Services::validation(),
    ];
    return view('profile/edit', $data);
  }

  public function edit_profil()
  {

    $getUser = $this->user_model->where('email',  session('email'))->first();
    $postFname = htmlspecialchars($this->request->getVar('full_name'));
    $postBplace = htmlspecialchars($this->request->getVar('birthplace'));
    $postBdate = htmlspecialchars($this->request->getVar('birthdate'));
    $postRel = htmlspecialchars($this->request->getVar('religion'));
    $postGender = htmlspecialchars($this->request->getVar('gender'));
    $postPhone = htmlspecialchars($this->request->getVar('phone'));
    $postEmail = htmlspecialchars($this->request->getVar('email'));
    $postAddress = htmlspecialchars($this->request->getVar('address'));

    // Cek apakah email baru = email yang lama
    if ($postEmail != $getUser['email']) {
      $ruleEmail = 'required|valid_email|is_unique[users.email]';
    } else {
      $ruleEmail = 'required|valid_email';
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
      'birthplace' => [
        'rules' => 'permit_empty|alpha_space',
        'errors' => [
          'alpha_space' => 'Yang anda masukkan bukan karakter alfabet dan spasi.',
        ]
      ],
      'birthdate' => [
        'rules' => 'permit_empty|alpha_dash',
        'errors' => [
          'alpha_dash' => 'Yang anda masukkan tidak sesuai placeholder.',
        ]
      ],
      'religion' => [
        'rules' => 'in_list[0,Buddha,Hindhu,Islam,Katholik,Konghucu,Kristen]',
        'errors' => [
          'in_list' => 'Pilihan tidak terdaftar.',
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
      'address' => [
        'rules' => 'permit_empty|alpha_numeric_punct',
      ],
    ];
    // validasi
    if (!$this->validate($validate)) {
      redirect()->to(base_url('profil/edit'))->withInput();
    }

    // Cek pilih agama atau tidak
    if ($postRel == '0') {
      $rel = Null;
    } else {
      $rel = $postRel;
    }

    // Cek birthdate terisi
    if ($postBdate == null) {
      $bdate = null;
    } elseif ($postBdate == $getUser['birthdate']) {
      $bdate = $getUser['birthdate'];
    } else {
      $bdate = $this->time->createFromFormat('d-m-Y', $postBdate);
    }

    $this->user_model->save([
      'id' => $getUser['id'],
      'full_name' => $postFname,
      'birthplace' => $postBplace,
      'birthdate' => $bdate,
      'religion' => $rel,
      'gender' => $postGender,
      'phone' => $postPhone,
      'email' => $postEmail,
      'address' => $postAddress,
    ]);

    $session = session();
    $session->remove(['email', 'full_name']);
    $session->set(['email' => $postEmail, 'full_name' => $postFname]);

    $msg = "Anda berhasil memperbarui akun anda!";
    flashAlert('success', $msg, 'bi-check-circle-fill');
    return redirect()->to(base_url('profil/edit'));
  }

  public function change_photo()
  {
    $getUser = $this->user_model->where('email',  session('email'))->first();
    $postFoto = $this->request->getFile('photo');

    $validate = [
      'photo' => [
        'rules' => 'max_size[photo,5120]|mime_in[photo,image/png,image/jpg]',
        'errors' => [
          'max_size' => 'Ukuran file melebihi 5Mb.',
          'mime_in' => 'File yang diunggah bukan gambar.'
        ]
      ],
    ];

    // validasi
    if (!$this->validate($validate)) {
      redirect()->to(base_url('profil/edit'))->withInput();
    }

    $new_name = $postFoto->getRandomName();
    // Upload file cek error
    if ($postFoto->getError() == 4) {
      $msg = "Belum ada file foto yang anda unggah, mohon unggah file foto terlebih dahulu.";
      $alert = "danger";
      $icon = 'bi-exclamation-circle-fill';
    } else {
      // Buat direktori jika belum ada
      if (!is_dir('foto_profil')) {
        mkdir('/foto_profil', 0777, TRUE);
      }
      // Cek apakah ada file foto milik user ini di folder foto_profil
      if ($getUser['photo'] == "default.svg") {
        $postFoto->move('foto_profil/', $new_name);
      } else if (fileExists('foto_profil/' . $getUser['photo']) && $getUser['photo'] != "default.svg") {
        unlink('foto_profil/' . $getUser['photo']);
        $postFoto->move('foto_profil/', $new_name);
      }
      $this->user_model->save([
        'id' => $getUser['id'],
        'photo' => $new_name,
      ]);

      $msg = "Berhasil mengganti foto profil anda!";
      $icon = 'bi-check-circle-fill';
      $alert = "success";
      $session = session();
      $session->remove('photo');
      $session->set('photo', $new_name);
    }
    flashAlert($alert, $msg, $icon);
    return redirect()->to(base_url('profil/edit'));
  }

  public function delete_photo()
  {
    $getUser = $this->user_model->where('email',  session('email'))->first();

    // cek photo bukan default.png atau null
    if ($getUser['photo'] != null || $getUser['photo'] == "default.svg") {
      unlink('foto_profil/' . $getUser['photo']);
      $new_name = 'default.svg';
      $this->user_model->save([
        'id' => $getUser['id'],
        'photo' => $new_name
      ]);
      $msg = "Anda berhasil menghapus foto profil anda!";
      $alert = "success";
      $icon = 'bi-check-circle-fill';
      $session = session();
      $session->remove('photo');
      $session->set('photo', $new_name);
    } else {
      $msg = "Anda tidak memiliki foto untuk dihapus.";
      $alert = "danger";
      $icon = 'bi-exclamation-circle-fill';
    }
    flashAlert($alert, $msg, $icon);
    return redirect()->to(base_url('profil/edit'));
  }

  public function change_password()
  {
    $getUser = $this->user_model->where('email',  session('email'))->first();
    $postPass1 = htmlspecialchars($this->request->getVar('password1'));
    $postPass2 = htmlspecialchars($this->request->getVar('password2'));

    $validate = [
      'password1' => [
        'rules'   => 'required|min_length[5]|matches[password2]',
        'errors'  => [
          'required'    => 'Mohon isi kolom password baru.',
          'min_length'  => 'Mohon isi kolom password baru minimal panjang 5 karakter.',
          'matches'     => 'Password baru tidak cocok.'
        ]
      ],
      'password2' => [
        'rules'   => 'required',
        'errors'  => [
          'required'    => 'Mohon isi kolom konfirmasi password baru.',
        ]
      ],
    ];

    // validasi
    if (!$this->validate($validate)) {
      redirect()->to(base_url('profil/edit'))->withInput();
    }

    // Cek password baru = password lama
    if ($postPass1 == $getUser['password']) {
      $msg = "Password baru tidak boleh sama dengan password lama anda.";
      $alert = "danger";
      $icon = 'bi-exclamation-circle-fill';
    } else {
      $password_hash = password_hash($postPass1, PASSWORD_DEFAULT);

      $this->user_model->save([
        'id' => $getUser['id'],
        'password' => $postPass1,
        'password_hash' => $password_hash,
      ]);
      $msg = "Anda berhasil mengganti password anda!";
      $alert = "success";
      $icon = 'bi-check-circle-fill';
    }
    flashAlert($alert, $msg, $icon);
    return redirect()->to(base_url('profil/edit'));
  }
}
