<?php

namespace App\Controllers;

use App\Models\User;

class Auth extends BaseController
{
    public function showLogin()
    {
        log_message('debug', '[AUTH] showLogin called. logged_in={logged}', [
            'logged' => session()->get('logged_in') ? '1' : '0',
        ]);

        if (session()->get('logged_in')) {
            log_message('debug', '[AUTH] showLogin redirecting authenticated user to /');
            return redirect()->to(base_url('/'));
        }

        return view('pages/login');
    }

    public function login()
    {
        log_message('debug', '[AUTH] login called. method={method} uri={uri}', [
            'method' => $this->request->getMethod(),
            'uri'    => (string) current_url(),
        ]);

        if (strtolower($this->request->getMethod()) !== 'post') {
            log_message('debug', '[AUTH] login rejected: method is not POST');
            return redirect()->to(base_url('login'));
        }

        $email = trim((string) $this->request->getPost('email'));
        $passwordInput = (string) $this->request->getPost('password');
        $rememberMe = $this->request->getPost('remember_me');

        log_message('debug', '[AUTH] login payload email={email} password_len={len} remember_me={remember}', [
            'email'    => $email,
            'len'      => (string) strlen($passwordInput),
            'remember' => $rememberMe ? '1' : '0',
        ]);

        if ($email === '' || $passwordInput === '') {
            log_message('debug', '[AUTH] login validation failed: empty email or password');
            return redirect()->to(base_url('login'))
                ->withInput()
                ->with('auth_error', 'E-mail e palavra-passe sao obrigatorios.');
        }

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            log_message('debug', '[AUTH] login validation failed: invalid email format');
            return redirect()->to(base_url('login'))
                ->withInput()
                ->with('auth_error', 'Introduza um e-mail valido.');
        }

        $userModel = new User();
        $db = \Config\Database::connect();
        try {
            $result = $userModel->getByEmail($email);
            log_message('debug', '[AUTH] getByEmail result found={found}', [
                'found' => $result ? '1' : '0',
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Login DB error: {message}', ['message' => $e->getMessage()]);

            return redirect()->to(base_url('login'))
                ->withInput()
                ->with('auth_error', 'Erro interno ao autenticar. Tente novamente.');
        }

        if (! $result || $result->password_hash === null || ! password_verify($passwordInput, $result->password_hash)) {
            log_message('debug', '[AUTH] login failed: invalid credentials or missing hash');
            return redirect()->to(base_url('login'))
                ->withInput()
                ->with('auth_error', 'Credenciais invalidas.');
        }

        $session = session();
        $session->regenerate();
        $session->set([
            'user_id' => $result->id,
            'user_name' => $result->name,
            'user_email' => $result->email,
            'is_admin' => (int) $result->is_admin,
            'logged_in' => true,
        ]);
        log_message('debug', '[AUTH] login success user_id={id} email={email}', [
            'id'    => (string) $result->id,
            'email' => $result->email,
        ]);

        if ($rememberMe) {
            helper('cookie');

            try {
                $token = bin2hex(random_bytes(32));
                $tokenHash = hash('sha256', $token);

                $db->table('remember_tokens')->insert([
                    'user_id' => $result->id,
                    'token_hash' => $tokenHash,
                    'expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
                ]);

                set_cookie('remember_token', $token, 60 * 60 * 24 * 30);
                log_message('debug', '[AUTH] remember_token saved for user_id={id}', [
                    'id' => (string) $result->id,
                ]);
            } catch (\Throwable $e) {
                // If remember_tokens is not available, continue with normal session login.
                log_message('error', '[AUTH] remember_token save failed: {message}', [
                    'message' => $e->getMessage(),
                ]);
            }
        }

        log_message('debug', '[AUTH] redirecting to / after login');
        return redirect()->to(base_url('/'));
    }

    public function logout()
    {
        log_message('debug', '[AUTH] logout called. logged_in={logged}', [
            'logged' => session()->get('logged_in') ? '1' : '0',
        ]);
        helper('cookie');

        $token = get_cookie('remember_token');

        if ($token) {
            try {
                $tokenHash = hash('sha256', $token);
                $db = \Config\Database::connect();
                $db->table('remember_tokens')->where('token_hash', $tokenHash)->delete();
            } catch (\Throwable $e) {
                // Ignore remember-token cleanup errors.
            }

            delete_cookie('remember_token');
        }

        $session = session();
        $session->destroy();
        log_message('debug', '[AUTH] session destroyed, redirecting to login');

        return redirect()->to(base_url('login'))->with('auth_info', 'Sessao terminada com sucesso.');
    }
}
