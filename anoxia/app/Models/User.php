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
        'is_admin',
        'is_active'
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

    public function createPendingUser(string $name, string $email): array
    {
        $table = $this->getUserTable();

        $this->db->table($table)->insert([
            'name' => $name,
            'email' => $email,
            'password_hash' => null,
        ]);

        $id = (int) $this->db->insertID();

        if ($id <= 0) {
            return ['success' => false, 'error' => 'Unable to create user.'];
        }

        return ['success' => true, 'user_id' => $id];
    }

    public function getAllForList(): array
    {
        return $this->db->table($this->getUserTable())
            ->select('id, name, email, is_admin, is_active, password_hash')
            ->orderBy('id', 'asc')
            ->get()
            ->getResult();
    }

    public function getDungeonMasterCount(): int
    {
        $row = $this->db->table('user_campaign')
            ->select('COUNT(DISTINCT user_id) AS total')
            ->where('is_dm', 1)
            ->get()
            ->getRow();

        return (int) ($row->total ?? 0);
    }

    public function getDashboardCounts(): array
    {
        $table = $this->getUserTable();
        $total = (int) $this->db->table($table)->countAllResults();
        $admin = (int) $this->db->table($table)->where('is_admin', 1)->countAllResults();
        $active = (int) $this->db->table($table)
            ->where('is_active', 1)
            ->where('password_hash IS NOT NULL', null, false)
            ->countAllResults();
        $inactive = (int) $this->db->table($table)->where('is_active', 0)->countAllResults();
        $pending = (int) $this->db->table($table)
            ->groupStart()
            ->where('is_active IS NULL', null, false)
            ->orWhere('password_hash IS NULL', null, false)
            ->groupEnd()
            ->countAllResults();
        $dm = $this->getDungeonMasterCount();

        return [
            'total' => $total,
            'admin' => $admin,
            'dm' => $dm,
            'pending' => $pending,
            'active' => $active,
            'inactive' => $inactive,
        ];
    }
}
