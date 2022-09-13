<?php

namespace App\Models;

use CodeIgniter\Model;

class OutgoingMailModel extends Model
{
    protected $table            = 'outgoing_mail';
    protected $primaryKey       = 'kd_suratkeluar';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['kd_jenissurat', 'nomor_surat', 'kd_user', 'tgl_buat', 'tgl_ttd', 'perihal', 'lampiran', 'deleted_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
