<?php

namespace App\Controllers;

use App\Models\UsersModel;
use \CodeIgniter\I18n\Time;

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
            'title' => 'SIKABEM - Login',
            'validation' => \Config\Services::validation(),
        ];
        return view('/auth/index', $data);
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
            ->select('users.kd_user AS kd_user, users.kd_jabatan AS id_jabatan, users.nama_user AS nama_user, users.email AS email,
            users.password_hash AS password_hash, users.foto AS foto, users.user_active AS user_active, users.is_login AS is_login')
            ->join('positions', 'positions.kd_jabatan = users.kd_jabatan')
            ->where(['email' => $inputEmail, 'user_active' => 1])
            ->first();

        // cek apakah email dan passwordnya match
        if ($getAccount) {
            // cek keaktifan akun
            if ($getAccount['user_active'] = 1) {
                if (password_verify($inputPass, $getAccount['password_hash'])) {
                    $userdata = [
                        'kd_user' => $getAccount['kd_user'],
                        'email' => $getAccount['email'],
                        'id_jabatan' => $getAccount['id_jabatan'],
                        'nama_user' => $getAccount['nama_user'],
                        'foto' => $getAccount['foto'],
                        'is_logged_in' => true,
                    ];
                    $this->user_model->save([
                        'kd_user' => $getAccount['kd_user'],
                        'is_login' => 1,
                        'log_date' => new Time('now'),
                    ]);

                    session()->set($userdata);
                    return redirect()->to(base_url() . '/profil');
                } else {
                    $msg = "Email atau Password salah.";
                    $icon = 'bi-exclamation-circle-fill';
                    flashAlert('danger', $msg, $icon);
                    return redirect()->to(base_url() . '/auth')->withInput();
                }
            } else {
                $msg = "Akun anda telah dinonaktifkan. Mohon hubungi admin untuk mengaktifkan kembali akun anda.";
                $icon = 'bi-exclamation-circle-fill';
                flashAlert('danger', $msg, $icon);
                return redirect()->to(base_url('auth'));
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
        // Ganti is_login menjadi 0
        $this->user_model->save([
            'kd_user' => session('kd_user'),
            'is_login' => 0,
            'log_date' => null
        ]);

        session()->destroy();

        $msg = "Anda berhasil logout.";
        flashAlert('success', $msg);
        return redirect()->to(base_url() . '/auth');
    }

    public function blocked()
    {
        $data = [
            'title' => '403 - Forbidden'
        ];

        return view('errors/403', $data);
    }
}
