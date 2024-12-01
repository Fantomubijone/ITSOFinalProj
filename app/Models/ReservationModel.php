<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservationModel extends Model
{
    protected $table = 'reservations';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email', 'item_id', 'reservation_date', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
