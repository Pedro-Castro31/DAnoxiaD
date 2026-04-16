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
            'user_id'    => $result->id,
            'user_name'  => $result->name,
            'user_email' => $result->email,
            'is_admin'   => (int) $result->is_admin,
            'user_theme' => $result->theme ?? 'medieval',
            'logged_in'  => true,
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

        $session = session();
        $userId = $session->get('user_id');

        // Delete all remember tokens for this user
        if ($userId) {
            try {
                $db = \Config\Database::connect();
                $deleted = $db->table('remember_tokens')->where('user_id', $userId)->delete();
                log_message('debug', '[AUTH] deleted {count} remember_tokens for user_id={id}', [
                    'count' => (string) $deleted,
                    'id' => (string) $userId,
                ]);
            } catch (\Throwable $e) {
                log_message('error', '[AUTH] remember_token delete failed: {message}', [
                    'message' => $e->getMessage(),
                ]);
            }
        }

        // Delete the cookie
        delete_cookie('remember_token');

        $session->destroy();
        log_message('debug', '[AUTH] session destroyed, redirecting to login');

        return redirect()->to(base_url('login'))->with('auth_info', 'Sessao terminada com sucesso.');
    }

    private function emailPalette(string $theme): array
    {
        return match ($theme) {
            'white' => [
                'header_bg'   => 'linear-gradient(135deg, #4f46e5 0%, #3730a3 42%, #1e1b72 100%)',
                'header_text' => '#ffffff',
                'btn_bg'      => '#4f46e5',
                'btn_text'    => '#ffffff',
                'body_bg'     => '#f8fafc',
                'body_text'   => '#0f172a',
                'footer_bg'   => '#e2e8f0',
                'footer_text' => '#64748b',
                'border'      => '#cbd5e1',
                'link_bg'     => '#e8eef5',
            ],
            'dark' => [
                'header_bg'   => 'linear-gradient(135deg, #2a2a2a 0%, #1e1e1e 42%, #111111 100%)',
                'header_text' => '#e4e4e4',
                'btn_bg'      => '#666666',
                'btn_text'    => '#e4e4e4',
                'body_bg'     => '#1a1a1a',
                'body_text'   => '#e4e4e4',
                'footer_bg'   => '#111111',
                'footer_text' => '#888888',
                'border'      => '#3a3a3a',
                'link_bg'     => '#242424',
            ],
            'carbonfox' => [
                'header_bg'   => 'linear-gradient(135deg, #282828 0%, #1c1c1c 42%, #0f0f0f 100%)',
                'header_text' => '#f2f4f8',
                'btn_bg'      => '#33b1ff',
                'btn_text'    => '#161616',
                'body_bg'     => '#161616',
                'body_text'   => '#f2f4f8',
                'footer_bg'   => '#0f0f0f',
                'footer_text' => '#b6b8bb',
                'border'      => '#3c3c3c',
                'link_bg'     => '#1c1c1c',
            ],
            'ember' => [
                'header_bg'   => 'linear-gradient(135deg, #241a10 0%, #181210 42%, #0f0f0f 100%)',
                'header_text' => '#f2f4f8',
                'btn_bg'      => '#bf7c40',
                'btn_text'    => '#fdf0e0',
                'body_bg'     => '#161616',
                'body_text'   => '#f2f4f8',
                'footer_bg'   => '#0f0f0f',
                'footer_text' => '#a08060',
                'border'      => '#3c3c3c',
                'link_bg'     => '#1c1c1c',
            ],
            default => [
                'header_bg'   => 'linear-gradient(135deg, #70472a 0%, #4b301f 42%, #2a1a12 100%)',
                'header_text' => '#f6e8cd',
                'btn_bg'      => '#c89b60',
                'btn_text'    => '#2d1c12',
                'body_bg'     => '#ffffff',
                'body_text'   => '#333333',
                'footer_bg'   => '#f5f5f5',
                'footer_text' => '#666666',
                'border'      => '#ddd',
                'link_bg'     => '#f5f5f5',
            ],
        };
    }

    public function recoverPassword()
    {
        log_message('debug', '[AUTH] recover called. method={method}', [
            'method' => $this->request->getMethod(),
        ]);

        if (strtolower($this->request->getMethod()) !== 'post') {
            log_message('debug', '[AUTH] recover rejected: method is not POST');
            return redirect()->to(base_url('login'));
        }

        $email = trim((string) $this->request->getPost('email'));

        log_message('debug', '[AUTH] recover payload email={email}', [
            'email' => $email,
        ]);

        if ($email === '') {
            log_message('debug', '[AUTH] recover validation failed: empty email');
            return redirect()->to(base_url('login'))
                ->with('auth_error', 'E-mail e obrigatorio.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            log_message('debug', '[AUTH] recover validation failed: invalid email format');
            return redirect()->to(base_url('login'))
                ->with('auth_error', 'Introduza um e-mail valido.');
        }

        $userModel = new User();
        try {
            $user = $userModel->getByEmail($email);
            
            if (!$user) {
                log_message('debug', '[AUTH] recover user not found for email={email}', [
                    'email' => $email,
                ]);
                // Don't reveal if user exists or not for security
                return redirect()->to(base_url('login'))
                    ->with('auth_info', 'Se o e-mail existir, recebera instrucoes de recuperacao.');
            }

            // Generate unique token
            $token = bin2hex(random_bytes(32));
            $tokenHash = hash('sha256', $token);
            $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $db = \Config\Database::connect();

            // Delete any existing tokens for this user
            $db->table('password_resets')->where('user_id', $user->id)->delete();

            // Insert new token
            $db->table('password_resets')->insert([
                'user_id' => $user->id,
                'token' => $tokenHash,
                'expires_at' => $expiresAt,
            ]);

            log_message('debug', '[AUTH] password reset token generated for user_id={id}', [
                'id' => (string) $user->id,
            ]);

            // Send email
            $resetLink = base_url('auth/reset-password?token=' . $token);

            $p = $this->emailPalette($user->theme ?? 'medieval');

            $emailService = \Config\Services::email();

            $emailService->setFrom(
                getenv('email.fromEmail') ?: 'anoxiadnd@gmail.com',
                getenv('email.fromName') ?: 'Anoxia DnD'
            );
            $emailService->setTo($email);
            $emailService->setSubject('Recuperacao de Palavra-passe - Anoxia');

            $emailBody = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: ' . $p['body_text'] . '; background: ' . $p['body_bg'] . '; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: ' . $p['header_bg'] . '; color: ' . $p['header_text'] . '; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: ' . $p['body_bg'] . '; padding: 30px; border: 1px solid ' . $p['border'] . '; }
        .button { display: inline-block; background: ' . $p['btn_bg'] . '; color: ' . $p['btn_text'] . '; padding: 14px 28px; text-decoration: none; border-radius: 6px; font-weight: bold; margin: 20px 0; }
        .footer { background: ' . $p['footer_bg'] . '; padding: 20px; text-align: center; font-size: 12px; color: ' . $p['footer_text'] . '; border-radius: 0 0 8px 8px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0; font-size: 28px;">Recuperacao de Palavra-passe</h1>
        </div>
        <div class="content">
            <p>Ola,</p>
            <p>Recebemos um pedido para redefinir a palavra-passe da sua conta Anoxia.</p>
            <p>Clique no botao abaixo para criar uma nova palavra-passe:</p>
            <div style="text-align: center;">
                <a href="' . $resetLink . '" class="button">Redefinir Palavra-passe</a>
            </div>
            <p>Ou copie e cole este link no seu navegador:</p>
            <p style="word-break: break-all; background: ' . $p['link_bg'] . '; padding: 10px; border-radius: 4px; font-size: 12px;">' . $resetLink . '</p>
            <p><strong>Este link expira em 1 hora.</strong></p>
            <p>Se nao solicitou esta alteracao, ignore este e-mail. A sua palavra-passe permanecera inalterada.</p>
        </div>
        <div class="footer">
            <p>© 2026 Anoxia DnD. Todos os direitos reservados.</p>
            <p>Este e um e-mail automatico. Por favor, nao responda a esta mensagem.</p>
        </div>
    </div>
</body>
</html>';

            $emailService->setMessage($emailBody);

            if ($emailService->send()) {
                log_message('debug', '[AUTH] password reset email sent to {email}', [
                    'email' => $email,
                ]);
            } else {
                log_message('error', '[AUTH] failed to send password reset email: {error}', [
                    'error' => $emailService->printDebugger(['headers']),
                ]);
            }

        } catch (\Throwable $e) {
            log_message('error', '[AUTH] recover error: {message}', ['message' => $e->getMessage()]);
        }

        // Always show the same message for security
        return redirect()->to(base_url('login'))
            ->with('auth_info', 'Se o e-mail existir, recebera instrucoes de recuperacao.');
    }

    public function resetPassword()
    {
        log_message('debug', '[AUTH] resetPassword called. method={method}', [
            'method' => $this->request->getMethod(),
        ]);

        $method = strtolower($this->request->getMethod());
        $db = \Config\Database::connect();
        $userModel = new User();

        if ($method === 'get') {
            $token = trim((string) $this->request->getGet('token'));

            if ($token === '') {
                return redirect()->to(base_url('login'))
                    ->with('auth_error', 'Token invalido ou expirado.');
            }

            $tokenHash = hash('sha256', $token);
            $now = date('Y-m-d H:i:s');
            $reset = $db->table('password_resets')
                ->where('token', $tokenHash)
                ->where('expires_at >=', $now)
                ->get()
                ->getRow();

            if (! $reset) {
                return redirect()->to(base_url('login'))
                    ->with('auth_error', 'Token invalido ou expirado.');
            }

            $user = $db->table($userModel->getUserTable())
                ->select('id, email, name')
                ->where('id', $reset->user_id)
                ->get()
                ->getRow();

            if (! $user) {
                return redirect()->to(base_url('login'))
                    ->with('auth_error', 'Token invalido ou expirado.');
            }

            return view('pages/login_set_password', [
                'token' => $token,
                'email' => $user->email,
            ]);
        }

        if ($method !== 'post') {
            return redirect()->to(base_url('login'));
        }

        $token = trim((string) $this->request->getPost('token'));
        $password = (string) $this->request->getPost('password');
        $passwordConfirm = (string) $this->request->getPost('password_confirm');

        if ($token === '') {
            return redirect()->to(base_url('login'))
                ->with('auth_error', 'Token invalido ou expirado.');
        }

        if ($password === '' || $passwordConfirm === '') {
            return redirect()->back()
                ->with('reset_error', 'Preencha todos os campos.');
        }

        if (strlen($password) < 8) {
            return redirect()->back()
                ->with('reset_error', 'A palavra-passe deve ter pelo menos 8 caracteres.');
        }

        if ($password !== $passwordConfirm) {
            return redirect()->back()
                ->with('reset_error', 'As palavras-passe nao coincidem.');
        }

        $tokenHash = hash('sha256', $token);
        $now = date('Y-m-d H:i:s');
        $reset = $db->table('password_resets')
            ->where('token', $tokenHash)
            ->where('expires_at >=', $now)
            ->get()
            ->getRow();

        if (! $reset) {
            return redirect()->to(base_url('login'))
                ->with('auth_error', 'Token invalido ou expirado.');
        }

        try {
            $db->table($userModel->getUserTable())
                ->where('id', $reset->user_id)
                ->update([
                    'password_hash' => password_hash($password, PASSWORD_DEFAULT),
                ]);

            $db->table('password_resets')
                ->where('user_id', $reset->user_id)
                ->delete();
        } catch (\Throwable $e) {
            log_message('error', '[AUTH] resetPassword update failed: {message}', [
                'message' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->with('reset_error', 'Erro ao atualizar a palavra-passe. Tente novamente.');
        }

        return redirect()->to(base_url('login'))
            ->with('auth_info', 'Palavra-passe atualizada com sucesso.');
    }
}
