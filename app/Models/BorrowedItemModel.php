<?php

namespace App\Models;

use CodeIgniter\Model;

class BorrowedItemModel extends Model
{
    protected $table = 'borrowed_item';
    protected $primaryKey = 'id';
    protected $allowedFields = ['item_id', 'email', 'borrow_date', 'return_date'];
}
