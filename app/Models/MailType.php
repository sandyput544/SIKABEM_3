<?php

namespace App\Models;

use CodeIgniter\Model;

class MailType extends Model
{
    protected $table            = 'mail_type';
    protected $primaryKey       = 'kd_jenissurat';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['kode_surat', 'nama_jenis', 'deleted_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
