<?php

namespace App\Models;

use CodeIgniter\Model;

class PositionMenuModel extends Model
{
    protected $table            = 'position_menu';
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['kd_jabatan', 'kd_menu'];
}
