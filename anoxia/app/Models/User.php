<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    protected $table = 'app_user';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name',
        'email',
        'password_hash',
        'is_admin'
    ];
    protected $useTimestamps = false;
}
