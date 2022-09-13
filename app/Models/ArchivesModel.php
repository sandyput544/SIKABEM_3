<?php

namespace App\Models;

use CodeIgniter\Model;

class ArchivesModel extends Model
{
    protected $table            = 'archives';
    protected $primaryKey       = 'kd_arsip';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['kd_kategori', 'nomor_arsip', 'nama_arsip', 'nama_file', 'ukuran_file', 'mime', 'tgl_buat', 'nama_pembuat', 'id_uploader', 'deleted_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
