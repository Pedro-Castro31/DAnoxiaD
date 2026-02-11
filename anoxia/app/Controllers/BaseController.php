<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        helper(['cookie']);

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // $this->session = service('session');
        
        // Check remember-me token if user not logged in
        $session = session();
        if (!$session->get('logged_in')) {
            $token = get_cookie('remember_token');
            
            if ($token) {
                $tokenHash = hash('sha256', $token);
                
                $db = \Config\Database::connect();
                $record = $db->table('remember_tokens')
                    ->where('token_hash', $tokenHash)
                    ->where('expires_at >', date('Y-m-d H:i:s'))
                    ->get()
                    ->getRow();
                
                if ($record) {
                    // Get user details
                    $user = $db->table('users')
                        ->where('id', $record->user_id)
                        ->get()
                        ->getRow();
                    
                    if ($user) {
                        // Recreate session
                        $session->set([
                            'user_id' => $user->id,
                            'user_name' => $user->name,
                            'user_email' => $user->email,
                            'is_admin' => $user->is_admin,
                            'logged_in' => true
                        ]);
                    }
                }
            }
        }
    }
}
