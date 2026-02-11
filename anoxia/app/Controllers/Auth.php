<?php

namespace App\Controllers;

use App\Models\User;

class Auth extends BaseController
{
    public function login()
    {
        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');
            $passwordInput = $this->request->getPost('password');
            $rememberMe = $this->request->getPost('remember_me');
            
            $db = \Config\Database::connect();
            $result = $db->query("CALL sp_get_user_by_email(?)", [$email])->getRow();
            
            if ($result && $result->password_hash === null) {
                 // Handle null password case
            }
            else if ($result && password_verify($passwordInput, $result->password_hash)) {
                // login success
                
                // Start session and store user data
                $session = session();
                $session->set([
                    'user_id' => $result->id,
                    'user_name' => $result->name,
                    'user_email' => $result->email,
                    'is_admin' => $result->is_admin,
                    'logged_in' => true
                ]);
                
                // Handle remember-me token if checked
                if ($rememberMe) {
                    helper('cookie');
                    
                    $token = bin2hex(random_bytes(32));
                    $tokenHash = hash('sha256', $token);
                    
                    $db->table('remember_tokens')->insert([
                        'user_id' => $result->id,
                        'token_hash' => $tokenHash,
                        'expires_at' => date('Y-m-d H:i:s', strtotime('+30 days'))
                    ]);
                    
                    set_cookie('remember_token', $token, 60 * 60 * 24 * 30);
                }
            } else {
                // login failed
            }
        }
        
        return redirect()->to('/');
    }
}
