<?php

namespace App\Controllers;

use App\Models\User;

class Home extends BaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();
        
        try {
            $userModel = new User();
            $users = $db->table($userModel->getUserTable())->get()->getResult();
            $users = $this->attachDerivedDmFlag($users, $userModel);
            $data['users'] = $users;
            $data['db_status'] = 'Connected';
        } catch (\Exception $e) {
            $data['users'] = [];
            $data['db_status'] = 'Error: ' . $e->getMessage();
        }
        
        return view('pages/home', $data);
    }

    /**
     * Derive is_dm from user_campaign (independent of campaign active state).
     *
     * @param list<object> $users
     * @return list<object>
     */
    private function attachDerivedDmFlag(array $users, User $userModel): array
    {
        if (empty($users)) {
            return $users;
        }

        $dmMap = $userModel->getActiveDmUserIdMap();

        foreach ($users as $user) {
            $userId = (int) ($user->id ?? 0);
            $user->derived_is_dm = isset($dmMap[$userId]) ? 1 : 0;
        }

        return $users;
    }
}
