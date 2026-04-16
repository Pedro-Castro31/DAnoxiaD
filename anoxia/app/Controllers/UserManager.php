<?php

namespace App\Controllers;

use App\Models\Campaign;
use App\Models\User;

class UserManager extends BaseController
{
	public function index(): string
	{
		$userModel = new User();
		$users = $userModel->getAllForList();
		$counts = $userModel->getDashboardCounts();

		$campaignModel = new Campaign();
		$dmIds = array_flip($campaignModel->getActiveDmUserIds());
		foreach ($users as $user) {
			$user->is_dm_active = isset($dmIds[(int) $user->id]);
		}

		return view('pages/admin_dashboard', [
			'users' => $users,
			'totalUsers' => $counts['total'],
			'adminUsers' => $counts['admin'],
			'dmUsers' => $counts['dm'],
			'pendingUsers' => $counts['pending'],
			'activeUsers' => $counts['active'],
			'inactiveUsers' => $counts['inactive'],
		]);
	}

	public function create()
	{
		$rules = [
			'name' => 'required|min_length[2]|max_length[120]',
			'email' => 'required|valid_email|max_length[190]',
		];

		if (!$this->validate($rules)) {
			return redirect()->back()->withInput()->with('user_error', 'Invalid user details.');
		}

		$name = trim((string) $this->request->getPost('name'));
		$email = trim((string) $this->request->getPost('email'));

		$userModel = new User();
		$existing = $userModel->getByEmail($email);
		if ($existing) {
			return redirect()->back()->withInput()->with('user_error', 'Email already exists.');
		}

		$result = $userModel->createPendingUser($name, $email);
		if (!$result['success']) {
			return redirect()->back()->withInput()->with('user_error', $result['error'] ?? 'Unable to create user.');
		}

		$user = (object) [
			'id' => $result['user_id'],
			'name' => $name,
			'email' => $email,
		];

		$this->setPasswordEmail($user);

		return redirect()->to(base_url('dashboardtest'))->with('user_info', 'User created.');
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
		];
	}

	private function setPasswordEmail(object $user): void
	{
		$token = bin2hex(random_bytes(32));
		$tokenHash = hash('sha256', $token);
		$expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

		$db = \Config\Database::connect();
		$db->table('password_resets')->where('user_id', $user->id)->delete();
		$db->table('password_resets')->insert([
			'user_id' => $user->id,
			'token' => $tokenHash,
			'expires_at' => $expiresAt,
		]);

		$setPasswordLink = base_url('auth/reset-password?token=' . $token);

		$emailService = \Config\Services::email();
		$emailService->setFrom(
			getenv('email.fromEmail') ?: 'anoxiadnd@gmail.com',
			getenv('email.fromName') ?: 'Anoxia DnD'
		);
		$emailService->setTo($user->email);
		$emailService->setSubject('Definir Palavra-passe - Anoxia');

		// New users have no theme yet; use the admin's current session theme
		$adminTheme = (string) (session()->get('user_theme') ?? 'medieval');
		$p = $this->emailPalette($adminTheme);

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
            <h1 style="margin: 0; font-size: 28px;">Definir Palavra-passe</h1>
        </div>
        <div class="content">
            <p>Ola ' . esc($user->name) . ',</p>
            <p>A sua conta Anoxia foi criada. Clique no botao abaixo para definir a sua palavra-passe:</p>
            <div style="text-align: center;">
                <a href="' . $setPasswordLink . '" class="button">Definir Palavra-passe</a>
            </div>
            <p>Ou copie e cole este link no seu navegador:</p>
            <p style="word-break: break-all; background: ' . $p['link_bg'] . '; padding: 10px; border-radius: 4px; font-size: 12px;">' . $setPasswordLink . '</p>
            <p><strong>Este link expira em 1 hora.</strong></p>
            <p>Se nao solicitou esta conta, ignore este e-mail.</p>
        </div>
        <div class="footer">
            <p>© 2026 Anoxia DnD. Todos os direitos reservados.</p>
            <p>Este e um e-mail automatico. Por favor, nao responda a esta mensagem.</p>
        </div>
    </div>
</body>
</html>';

		$emailService->setMessage($emailBody);
		$emailService->send();
	}
}
