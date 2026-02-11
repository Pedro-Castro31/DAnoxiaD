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

		$emailBody = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #70472a 0%, #4b301f 42%, #2a1a12 100%); color: #f6e8cd; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #fff; padding: 30px; border: 1px solid #ddd; }
        .button { display: inline-block; background: #c89b60; color: #2d1c12; padding: 14px 28px; text-decoration: none; border-radius: 6px; font-weight: bold; margin: 20px 0; }
        .footer { background: #f5f5f5; padding: 20px; text-align: center; font-size: 12px; color: #666; border-radius: 0 0 8px 8px; }
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
            <p style="word-break: break-all; background: #f5f5f5; padding: 10px; border-radius: 4px; font-size: 12px;">' . $setPasswordLink . '</p>
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
