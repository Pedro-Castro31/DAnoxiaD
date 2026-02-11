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
            $data['users'] = $users;
            $data['db_status'] = 'Connected';
        } catch (\Exception $e) {
            $data['users'] = [];
            $data['db_status'] = 'Error: ' . $e->getMessage();
        }
        
        return view('pages/home', $data);
    }
}
