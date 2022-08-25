<?php

namespace App\Models;

use CodeIgniter\Model;

class MenusModel extends Model
{
    protected $table            = 'menus';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['menu_name', 'menu_url', 'menu_icon', 'is_active', 'deleted_at'];
}
