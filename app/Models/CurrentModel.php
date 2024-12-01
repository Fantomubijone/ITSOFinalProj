<?php

namespace App\Models;

use CodeIgniter\Model;

class CurrentModel extends Model
{
    protected $table = 'current';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'user_id', 'first_name', 'last_name', 'email'];

}
