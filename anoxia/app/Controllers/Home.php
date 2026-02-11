<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();
        
        try {
            $users = $db->table('app_user')->get()->getResult();
            $data['users'] = $users;
            $data['db_status'] = 'Connected';
        } catch (\Exception $e) {
            $data['users'] = [];
            $data['db_status'] = 'Error: ' . $e->getMessage();
        }
        
        return view('pages/home', $data);
    }
}
