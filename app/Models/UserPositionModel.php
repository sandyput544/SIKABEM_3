<?php

namespace App\Models;

use CodeIgniter\Model;

class UserPositionModel extends Model
{
    protected $table            = 'user_position';
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'pos_id'];
}
