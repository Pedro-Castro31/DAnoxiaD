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

    public function getUserTable(): string
    {
        if ($this->db->tableExists('app_user')) {
            return 'app_user';
        }

        if ($this->db->tableExists('users')) {
            return 'users';
        }

        return $this->table;
    }

    public function getByEmail(string $p_email): ?object
    {
        return $this->db->table($this->getUserTable())
            ->select('id, name, email, password_hash, is_admin')
            ->where('email', $p_email)
            ->limit(1)
            ->get()
            ->getRow();
    }
}
