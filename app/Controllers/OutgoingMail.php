<?php

namespace App\Controllers;

use \App\Models\MailType;
use \App\Models\OutgoingMail;

class OutgoingMail extends BaseController
{
  protected $mailtype;
  protected $outmail;
  public function __construct()
  {
    $this->mailtype = new MailType();
    $this->outmail = new OutgoingMail();
  }
  public function index()
  {
    $data = [
      'title'       => 'Master Surat Keluar',
      'navbar'      => 'Surat Keluar',
      'card'        => 'List Surat Keluar',
      'archives'  => $this->outmail
        ->findAll()
    ];

    return view('outmail/index', $data);
  }

  public function add()
  {
    $data = [
      'title'       => 'Buat Surat Keluar',
      'navbar'      => 'Surat Keluar',
      'card'        => 'Form Buat Surat Keluar',
      'validation'  => \Config\Services::validation()
    ];

    return view('outmail/add', $data);
  }
  public function insert()
  {
    $postJenisSurat = $this->request->getVar('kd_jenissurat');
    $postNoSurat = $this->request->getVar('nomor_surat');
    $postTglBuat = $this->request->getVar('tgl_buat');
    $postTglTtd = $this->request->getVar('tgl_ttd');
    $postPerihal = $this->request->getVar('perihal');
    $postLampiran = $this->request->getVar('lampiran');

    $getJenisSurat = implode(",", $this->mailtype->findColumn('kd_jenissurat'));
    $validate = [
      'kd_jenissurat' => [
        'rules' => 'required|in_list[' . $getJenisSurat . ']',
        'errors' => [

          'in_list' => 'Pilihan tidak tersedia.',
        ]
      ],
      'nomor_surat' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Mohon isi kolom nomor surat.',
        ]
      ],
      'tgl_buat' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Mohon isi kolom tanggal buat arsip.',
        ]
      ],
      'tgl_ttd' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Mohon isi kolom tanggal tanda tangan.',
        ]
      ],
      'perihal' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Mohon isi kolom perihal.',
        ]
      ],
      'lampiran' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Mohon isi kolom lampiran.',
        ]
      ],
    ];

    if (!validate($validate)) {
      return redirect()->to(base_url('surat-keluar/buat'))->withInput();
    } else {
    }
  }
}
