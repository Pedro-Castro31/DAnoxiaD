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
}
