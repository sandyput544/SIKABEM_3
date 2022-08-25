<?php

namespace App\Models;

use CodeIgniter\Model;

class PositionMenuModel extends Model
{
    protected $table            = 'position_menu';
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['pos_id', 'menu_id'];
}
