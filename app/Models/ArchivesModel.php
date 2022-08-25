<?php

namespace App\Models;

use CodeIgniter\Model;

class ArchivesModel extends Model
{
    protected $table            = 'archives';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['cat_id', 'archive_name', 'file_name', 'file_ext', 'file_size', 'mime_type', 'deleted_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
}
