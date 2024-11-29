<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'school_id', 'first_name', 'last_name', 'email', 'password', 'user_type', 'status', 'activation_code'
    ];
}
