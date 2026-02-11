<?php

namespace App\Controllers;

use App\Models\Campaign;
use App\Models\User;

class CampaignManager extends BaseController
{
	public function index(): string
	{
		$campaignModel = new Campaign();
		$campaigns = $campaignModel->getAllWithDm();

		$userModel = new User();
		$users = $userModel->getAllForSelect();

		return view('pages/campaign_dashboard', [
			'campaigns' => $campaigns,
			'users' => $users,
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
