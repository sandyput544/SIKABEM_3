<?php

namespace App\Models;

use CodeIgniter\Model;

class PositionsModel extends Model
{
    protected $table            = 'positions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['pos_name', 'is_active', 'deleted_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
}
