<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Auth extends BaseController
{
    protected $session;
    protected $user_model;

    public function __construct()
    {
        helper('bem');
        $this->user_model = new UsersModel();
    }

    public function index()
    {
        $data = [
            'title' => 'SIBEM - Login',
            'validation' => \Config\Services::validation(),
        ];
        return view('/auth/index', $data);
    }

    public function forgotten()
    {
        $inputEmail = htmlspecialchars($this->request->getVar('email'));
        $getAccount = $this->user_model->where(['email' => $inputEmail])->first();
        // cek apakah email sudah terdaftar
        if ($getAccount['email']) {
            session()->setFlashdata('pesan', '
            <div class="col-12"><div class="alert alert-success" role="alert">
            Mohon untuk mengecek email dan mengaktivasi akun!
            </div></div>
            ');
            return redirect()->to(base_url('/auth/lupa-password'));
        } else {
            session()->setFlashdata('pesan', '
            <div class="col-12"><div class="alert alert-danger" role="alert">
            Email salah!
            </div></div>
            ');
            return redirect()->to(base_url('/auth/lupa-password'));
        }
    }

    public function login()
    {
        // Validasi form
        if (!$this->validate([
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Mohon isi email terlebih dahulu.',
                    'valid_email' => 'Mohon isi kolom email dengan benar.',
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Mohon isi password terlebih dahulu.'
                ]
            ]
        ])) {
            return redirect()->to(base_url() . '/auth')->withInput();
        }

        $inputEmail = htmlspecialchars($this->request->getVar('email'));
        $inputPass = htmlspecialchars($this->request->getVar('password'));
        $getAccount = $this->user_model
            ->join('user_position', 'user_position.user_id = users.id')
            ->where(['email' => $inputEmail])
            ->first();

        // cek apakah email dan passwordnya match
        if ($getAccount) {
            // cek password 
            // password_verify(password_yang_ingin_dicek, password_yang_tersimpan)

            if (password_verify($inputPass, $getAccount['password_hash'])) {
                $userdata = [
                    'email' => $getAccount['email'],
                    'pos_id' => $getAccount['pos_id'],
                    'full_name' => $getAccount['full_name'],
                    'photo' => $getAccount['photo'],
                    'is_logged_in' => true,
                ];
                session()->set($userdata);
                return redirect()->to(base_url() . '/profil');
            } else {
                $msg = "Email atau Password salah.";
                $icon = 'bi-exclamation-circle-fill';
                flashAlert('danger', $msg, $icon);
                return redirect()->to(base_url() . '/auth')->withInput();
            }
        } else {
            $msg = "Email atau Password salah.";
            $icon = 'bi-exclamation-circle-fill';
            flashAlert('danger', $msg, $icon);
            return redirect()->to(base_url() . '/auth')->withInput();
        }
    }

    public function logout()
    {
        session()->destroy();

        $msg = "Anda berhasil logout.";
        $icon = 'bi-check-circle-fill';
        flashAlert('success', $msg, $icon);
        return redirect()->to(base_url() . '/auth');
    }

    public function blocked()
    {
        echo "access blocked.";
    }
}
