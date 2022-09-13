<?php

namespace App\Controllers;

class OutgoingMail extends BaseController
{
  protected $phpWord;
  protected $word;
  protected $mailtype;
  protected $outmail;
  public function __construct()
  {
    $this->phpWord = new \PhpOffice\PhpWord\PhpWord();
    $this->word = new \PhpOffice\PhpWord\Writer\Word2007();
    $this->mailtype = new \App\Models\MailTypeModel;
    $this->outmail = new \App\Models\OutgoingMailModel();
  }

  // Fitur tampil data
  public function index()
  {
    $data = [
      'title'   => 'Master Surat Keluar',
      'navbar'  => 'Surat Keluar',
      'card'    => 'List Surat Keluar',
      'mail'    => $this->outmail
        ->select('outgoing_mail.kd_suratkeluar AS kd_suratkeluar, mail_type.nama_jenis AS nama_jenis, outgoing_mail.nomor_surat AS nomor_surat, outgoing_mail.kd_user AS id_user, users.nama_user AS nama_user, outgoing_mail.created_at AS waktu_buat')
        ->join('mail_type', 'mail_type.kd_jenissurat = outgoing_mail.kd_jenissurat', 'LEFT')
        ->join('users', 'users.kd_user = outgoing_mail.kd_user', 'LEFT')
        // ->orderBy('mail_type.kd_jenissurat', 'ASC')
        ->orderBy('nomor_surat', 'DESC')
        ->findAll()
    ];

    return view('outmail_view/index', $data);
  }

  // Fitur buat surat
  public function add()
  {
    $data = [
      'title'       => 'Buat Surat Keluar',
      'navbar'      => 'Surat Keluar',
      'card'        => 'Form Buat Surat Keluar',
      'mailtype'    => $this->mailtype->findAll(),
      'validation'  => \Config\Services::validation()
    ];

    return view('outmail_view/add', $data);
  }
  public function insert()
  {
    $postJenisSurat = $this->request->getVar('kd_jenissurat');
    $postNoSurat = $this->request->getVar('nomor_surat');
    $postPerihal = $this->request->getVar('perihal');
    $postLampiran = $this->request->getVar('lampiran');
    $postTglBuat = $this->request->getVar('tgl_buat');
    $postTglTtd = $this->request->getVar('tgl_ttd');

    $getImpJS = implode(",", $this->mailtype->findColumn('kd_jenissurat'));
    $validate = [
      'kd_jenissurat' => [
        'rules' => 'in_list[' . $getImpJS . ']',
        'errors' => [
          'required' => 'Mohon isi kolom judul surat.',
        ]
      ],
      'nomor_surat' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Mohon isi kolom nomor surat.',
        ]
      ]
    ];

    if (!$this->validate($validate)) {
      return redirect()->to(base_url('surat-keluar/buat'))->withInput();
    } else {

      $getMType = $this->mailtype->find($postJenisSurat);

      createWord($getMType['nama_jenis'], $postNoSurat);

      $this->outmail->save([
        'kd_jenissurat' => $postJenisSurat,
        'nomor_surat' => $postNoSurat,
        'perihal' => $postPerihal,
        'lampiran' => $postLampiran,
        'tgl_buat' => $postTglBuat,
        'tgl_ttd' => $postTglTtd,
      ]);

      $msg = "Berhasil membuat surat keluar.";
      flashAlert('success', $msg);
      return redirect()->to(base_url('surat-keluar'));
    }
  }

  // Fitur hapus
  public function delete($id)
  {
    $getMail = $this->outmail
      ->join('mail_type', 'mail_type.kd_jenissurat = outgoing_mail.kd_jenissurat')
      ->find($id);
    $msg = "Berhasil menghapus data surat : " . $getMail['nama_jenis'] . " dengan nomor : " . $getMail['nomor_surat'] . ".";
    flashAlert('success', $msg);
    $this->outmail->delete($id);

    return redirect()->to(base_url('surat-keluar'));
  }

  // Fitur tampil data terhapus
  public function show_all_deleted()
  {
    $data = [
      'title'   => 'Surat Keluar Terhapus',
      'navbar'  => 'Surat Keluar',
      'card'    => 'List Surat Keluar Yang Terhapus',
      'mail'    => $this->outmail
        ->select('outgoing_mail.kd_suratkeluar AS kd_suratkeluar, mail_type.nama_jenis AS nama_jenis, outgoing_mail.nomor_surat AS nomor_surat, outgoing_mail.kd_user AS id_user, users.nama_user AS nama_user, outgoing_mail.deleted_at AS tgl_delete')
        ->join('mail_type', 'mail_type.kd_jenissurat = outgoing_mail.kd_jenissurat', 'LEFT')
        ->join('users', 'users.kd_user = outgoing_mail.kd_user', 'LEFT')
        ->onlyDeleted()
        ->findAll()
    ];

    return view('outmail_view/deleted', $data);
  }

  // Fitur pulihkan semua
  public function restore_all()
  {
    $this->outmail->set(['deleted_at' => null])->update();

    $msg = "Berhasil memulihkan semua data surat yang terhapus.";
    flashAlert('success', $msg);
    return redirect()->to(base_url('surat-keluar/terhapus'));
  }

  // Fitur pulihkan satu
  public function restore_one($id)
  {
    $getMail = $this->outmail
      ->join('mail_type', 'mail_type.kd_jenissurat = outgoing_mail.kd_jenissurat')
      ->onlyDeleted()
      ->find($id);
    $this->outmail->save([
      'kd_suratkeluar' => $id,
      'deleted_at' => null
    ]);

    $msg = "Berhasil memulihkan data surat : " . $getMail['nama_jenis'] . " dengan nomor : " . $getMail['nomor_surat'] . ".";
    flashAlert('success', $msg);
    return redirect()->to(base_url('surat-keluar/terhapus'));
  }

  // Fitur hapus permanen semua
  public function permanent_delete_all()
  {
    $this->outmail->purgeDeleted();

    $msg = "Berhasil menghapus permanen semua data surat yang terhapus.";
    flashAlert('success', $msg);
    return redirect()->to(base_url('surat-keluar/terhapus'));
  }

  // Fitur hapus permanen satu
  public function permanent_delete_one($id)
  {
    $getMail = $this->outmail
      ->join('mail_type', 'mail_type.kd_jenissurat = outgoing_mail.kd_jenissurat')
      ->onlyDeleted()
      ->find($id);
    $msg = "Berhasil menghapus permanen data surat : " . $getMail['nama_jenis'] . " dengan nomor : " . $getMail['nomor_surat'] . ".";

    $this->outmail->where('kd_suratkeluar', $id)->purgeDeleted();

    flashAlert('success', $msg);
    return redirect()->to(base_url('surat-keluar/terhapus'));
  }
}
