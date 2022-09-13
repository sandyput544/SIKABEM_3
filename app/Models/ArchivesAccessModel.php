<?php

namespace App\Models;

use CodeIgniter\Model;

class ArchivesAccessModel extends Model
{
    protected $table            = 'archives_access';
    protected $useAutoIncrement = true;
    protected $primaryKey       = 'kd_akses';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kd_arsip', 'kd_user', 'tgl_akses', 'keterangan'];
}
