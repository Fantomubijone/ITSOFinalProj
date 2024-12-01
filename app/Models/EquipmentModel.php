<?php

namespace App\Models;

use CodeIgniter\Model;

class EquipmentModel extends Model
{
    protected $table = 'equipment';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'item_id', 'name', 'status', 'category'];
}
