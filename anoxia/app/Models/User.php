<?php

namespace App\Models;

use App\Libraries\UserRole;
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
        $table = $this->getUserTable();
        $fieldNames = $this->db->getFieldNames($table);
        $select = ['id', 'name', 'email', 'password_hash'];

        if (in_array('is_admin', $fieldNames, true)) {
            $select[] = 'is_admin';
        }

        if (in_array('is_dm', $fieldNames, true)) {
            $select[] = 'is_dm';
        }

        return $this->db->table($table)
            ->select(implode(', ', $select))
            ->where('email', $p_email)
            ->limit(1)
            ->get()
            ->getRow();
    }

    public function resolveRole(object $user): string
    {
        $isAdmin = property_exists($user, 'is_admin') && (int) $user->is_admin === 1;
        $isDm = false;

        if (property_exists($user, 'id')) {
            $isDm = $this->hasDmCampaignRole((int) $user->id);
        } elseif (property_exists($user, 'is_dm')) {
            $isDm = (int) $user->is_dm === 1;
        }

        return UserRole::resolve($isAdmin, $isDm);
    }

    public function hasDmCampaignRole(int $userId): bool
    {
        if (! $this->db->tableExists('user_campaign')) {
            return false;
        }

        $fields = $this->db->getFieldNames('user_campaign');

        if (! in_array('user_id', $fields, true) || ! in_array('is_dm', $fields, true)) {
            return false;
        }

        return $this->db->table('user_campaign')
            ->select('user_id')
            ->where('user_id', $userId)
            ->where('is_dm', 1)
            ->limit(1)
            ->get()
            ->getRow() !== null;
    }

    /**
     * Quick permissions snapshot for a user.
     *
     * @return array{is_admin: bool, is_dm: bool, role: string}
     */
    public function getPermissionFlags(int $userId): array
    {
        $table = $this->getUserTable();
        $isAdmin = false;

        if ($userId > 0 && $this->db->tableExists($table)) {
            $fields = $this->db->getFieldNames($table);
            if (in_array('is_admin', $fields, true)) {
                $row = $this->db->table($table)
                    ->select('is_admin')
                    ->where('id', $userId)
                    ->limit(1)
                    ->get()
                    ->getRow();
                $isAdmin = $row !== null && (int) ($row->is_admin ?? 0) === 1;
            }
        }

        $isDm = $userId > 0 && $this->hasDmCampaignRole($userId);

        return [
            'is_admin' => $isAdmin,
            'is_dm' => $isDm,
            'role' => UserRole::resolve($isAdmin, $isDm),
        ];
    }

    /**
     * @return array<int, bool> map where key=user_id and value=true for users with active DM campaign.
     */
    public function getActiveDmUserIdMap(): array
    {
        if (! $this->db->tableExists('user_campaign')) {
            return [];
        }

        $fields = $this->db->getFieldNames('user_campaign');
        if (! in_array('user_id', $fields, true) || ! in_array('is_dm', $fields, true)) {
            return [];
        }

        $rows = $this->db->table('user_campaign')
            ->select('user_id')
            ->where('is_dm', 1)
            ->groupBy('user_id')
            ->get()
            ->getResultArray();
        $map = [];
        foreach ($rows as $row) {
            $map[(int) $row['user_id']] = true;
        }

        return $map;
    }
}
