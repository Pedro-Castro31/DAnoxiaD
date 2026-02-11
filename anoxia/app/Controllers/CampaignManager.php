<?php

namespace App\Controllers;

use App\Models\Campaign;
use App\Models\User;

class CampaignManager extends BaseController
{
	public function index(): string
	{
		$campaignModel = new Campaign();
		$search = trim((string) $this->request->getGet('q'));
		$dmFilterRaw = $this->request->getGet('dm');
		$statusFilter = strtolower(trim((string) $this->request->getGet('status')));
		$page = max(1, (int) ($this->request->getGet('page') ?? 1));
		$perPage = 8;

		$dmFilter = is_numeric($dmFilterRaw) && (int) $dmFilterRaw > 0 ? (int) $dmFilterRaw : null;
		$isActiveFilter = null;
		if ($statusFilter === 'active') {
			$isActiveFilter = 1;
		} elseif ($statusFilter === 'inactive') {
			$isActiveFilter = 0;
		}

		$result = $campaignModel->getFilteredWithDm($search, $dmFilter, $isActiveFilter, $page, $perPage);
		$campaigns = $result['items'];
		$total = (int) ($result['total'] ?? 0);
		$totalPages = max(1, (int) ceil($total / $perPage));
		if ($page > $totalPages) {
			$page = $totalPages;
			$result = $campaignModel->getFilteredWithDm($search, $dmFilter, $isActiveFilter, $page, $perPage);
			$campaigns = $result['items'];
		}

		$userModel = new User();
		$users = $userModel->getAllForSelect();
		$dmOptions = $campaignModel->getDmOptions();

		return view('pages/campaign_dashboard', [
			'campaigns' => $campaigns,
			'users' => $users,
			'dm_options' => $dmOptions,
			'filters' => [
				'q' => $search,
				'dm' => $dmFilter,
				'status' => in_array($statusFilter, ['active', 'inactive'], true) ? $statusFilter : 'all',
			],
			'pagination' => [
				'current_page' => $page,
				'per_page' => $perPage,
				'total' => $total,
				'total_pages' => $totalPages,
			],
		]);
	}

	public function create()
	{
		$rules = [
			'name' => 'required|min_length[3]|max_length[120]',
			'description' => 'required|max_length[500]',
			'dm_email' => 'required|valid_email',
		];

		if (!$this->validate($rules)) {
			return redirect()->back()->withInput()->with('campaign_error', 'Invalid campaign details.');
		}

		$name = (string) $this->request->getPost('name');
		$description = (string) $this->request->getPost('description');
		$dmEmail = (string) $this->request->getPost('dm_email');

		$campaignModel = new Campaign();
		$result = $campaignModel->createWithDm($name, $description, $dmEmail);
		if (!$result['success']) {
			return redirect()->back()->withInput()->with('campaign_error', $result['error'] ?? 'Unable to create campaign.');
		}

		return redirect()->to(base_url('campaigntest'))->with('campaign_info', 'Campaign created.');
	}
}
