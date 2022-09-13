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
      ->join('positions', 'positions.kd_jabatan = users.kd_jabatan', 'LEFT')
      ->find(session('kd_user'));

    $data = [
      'title' => 'Profil Saya',
      'navbar' => 'Profil Saya',
      'card' => 'Profil Saya',
      'user' => $getuser,
      'validation' => \Config\Services::validation(),
    ];

    return view('profile/edit', $data);
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
    $postFname = htmlspecialchars($this->request->getVar('nama_user'));
    $postBplace = htmlspecialchars($this->request->getVar('tmp_lahir'));
    $postBdate = htmlspecialchars($this->request->getVar('tgl_lahir'));
    $postRel = htmlspecialchars($this->request->getVar('agama'));
    $postGender = htmlspecialchars($this->request->getVar('jk'));
    $postPhone = htmlspecialchars($this->request->getVar('no_hp'));
    $postEmail = htmlspecialchars($this->request->getVar('email'));
    $postAddress = htmlspecialchars($this->request->getVar('alamat'));

    // Cek apakah email baru = email yang lama
    if ($postEmail != $getUser['email']) {
      $ruleEmail = 'required|valid_email|is_unique[users.email]';
    } else {
      $ruleEmail = 'required|valid_email';
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
      'tmp_lahir' => [
        'rules' => 'permit_empty|alpha_space',
        'errors' => [
          'alpha_space' => 'Yang anda masukkan bukan karakter alfabet dan spasi.',
        ]
      ],
      'tgl_lahir' => [
        'rules' => 'permit_empty|alpha_dash',
        'errors' => [
          'alpha_dash' => 'Yang anda masukkan tidak sesuai placeholder.',
        ]
      ],
      'agama' => [
        'rules' => 'in_list[0,Buddha,Hindhu,Islam,Katholik,Konghucu,Kristen]',
        'errors' => [
          'in_list' => 'Pilihan tidak terdaftar.',
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
      'alamat' => [
        'rules' => 'permit_empty|alpha_numeric_punct',
      ],
    ];
    // validasi
    if (!$this->validate($validate)) {
      redirect()->to(base_url('profil'))->withInput();
    }

    // Cek pilih agama atau tidak
    if ($postRel == '0') {
      $rel = Null;
    } else {
      $rel = $postRel;
    }

    // Cek tgl_lahir terisi
    if ($postBdate == null) {
      $bdate = null;
    } elseif ($postBdate == $getUser['tgl_lahir']) {
      $bdate = $getUser['tgl_lahir'];
    } else {
      $bdate = $this->time->createFromFormat('d-m-Y', $postBdate);
    }

    $this->user_model->save([
      'kd_user' => $getUser['kd_user'],
      'nama_user' => $postFname,
      'tmp_lahir' => $postBplace,
      'tgl_lahir' => $bdate,
      'agama' => $rel,
      'jk' => $postGender,
      'no_hp' => $postPhone,
      'email' => $postEmail,
      'alamat' => $postAddress,
    ]);

    $session = session();
    $session->remove(['email', 'nama_user']);
    $session->set(['email' => $postEmail, 'nama_user' => $postFname]);

    $msg = "Anda berhasil memperbarui akun anda!";
    flashAlert('success', $msg);
    return redirect()->to(base_url('profil'));
  }

  public function change_photo()
  {
    $getUser = $this->user_model->where('email',  session('email'))->first();
    $postFoto = $this->request->getFile('foto');

    $validate = [
      'foto' => [
        'rules' => 'max_size[foto,5120]|mime_in[foto,image/png,image/jpg]',
        'errors' => [
          'max_size' => 'Ukuran file melebihi 5Mb.',
          'mime_in' => 'File yang diunggah bukan gambar.'
        ]
      ],
    ];

    // validasi
    if (!$this->validate($validate)) {
      redirect()->to(base_url('profil'))->withInput();
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
      if ($getUser['foto'] == "default.svg") {
        $postFoto->move('foto_profil/', $new_name);
      } else if (fileExists('foto_profil/' . $getUser['foto']) && $getUser['foto'] != "default.svg") {
        unlink('foto_profil/' . $getUser['foto']);
        $postFoto->move('foto_profil/', $new_name);
      }
      $this->user_model->save([
        'kd_user' => $getUser['kd_user'],
        'foto' => $new_name,
      ]);

      $msg = "Berhasil mengganti foto profil anda!";
      $icon = 'bi-check-circle-fill';
      $alert = "success";
      $session = session();
      $session->remove('foto');
      $session->set('foto', $new_name);
    }
    flashAlert($alert, $msg, $icon);
    return redirect()->to(base_url('profil'));
  }

  public function delete_photo()
  {
    $getUser = $this->user_model->where('email',  session('email'))->first();

    // cek photo bukan default.png atau null
    if ($getUser['foto'] != null || $getUser['foto'] == "default.svg") {
      unlink('foto_profil/' . $getUser['foto']);
      $new_name = 'default.svg';
      $this->user_model->save([
        'kd_user' => $getUser['kd_user'],
        'foto' => $new_name
      ]);
      $msg = "Anda berhasil menghapus foto profil anda!";
      $alert = "success";
      $icon = 'bi-check-circle-fill';
      $session = session();
      $session->remove('foto');
      $session->set('foto', $new_name);
    } else {
      $msg = "Anda tidak memiliki foto untuk dihapus.";
      $alert = "danger";
      $icon = 'bi-exclamation-circle-fill';
    }
    flashAlert($alert, $msg, $icon);
    return redirect()->to(base_url('profil'));
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
      redirect()->to(base_url('profil'))->withInput();
    }

    // Cek password baru = password lama
    if ($postPass1 == $getUser['password']) {
      $msg = "Password baru tidak boleh sama dengan password lama anda.";
      $alert = "danger";
      $icon = 'bi-exclamation-circle-fill';
    } else {
      $password_hash = password_hash($postPass1, PASSWORD_DEFAULT);

      $this->user_model->save([
        'kd_user' => $getUser['kd_user'],
        'password' => $postPass1,
        'password_hash' => $password_hash,
      ]);
      $msg = "Anda berhasil mengganti password anda!";
      $alert = "success";
      $icon = 'bi-check-circle-fill';
    }
    flashAlert($alert, $msg, $icon);
    return redirect()->to(base_url('profil'));
  }
}
