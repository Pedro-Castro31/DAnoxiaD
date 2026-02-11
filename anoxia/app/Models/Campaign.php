<?php

namespace App\Models;

use CodeIgniter\Model;

class Campaign extends Model
{
	protected $table = 'campaign';
	protected $primaryKey = 'id';
	protected $allowedFields = ['name', 'description'];
	protected $useTimestamps = false;

	public function getAll(): array
	{
		return $this->builder()
			->select('id, name, description')
			->orderBy('id', 'asc')
			->get()
			->getResult();
	}

	public function createWithDm(string $name, string $description, string $dmEmail): array
	{
		$db = $this->db;
		$userModel = new User();
		$userTable = $userModel->getUserTable();

		$db->transStart();

		$db->table($this->table)->insert([
			'name' => $name,
			'description' => $description,
		]);

		$campaignId = (int) $db->insertID();

		$userRow = $db
			->table($userTable)
			->select('id')
			->where('email', $dmEmail)
			->limit(1)
			->get()
			->getRow();

		if (!$userRow) {
			$db->transRollback();
			return ['success' => false, 'error' => 'Selected DM not found.'];
		}

		$db->table('user_campaign')->insert([
			'user_id' => $userRow->id,
			'campaign_id' => $campaignId,
			'is_dm' => 1,
		]);

		$db->transComplete();

		if ($db->transStatus() === false) {
			return ['success' => false, 'error' => 'Unable to create campaign.'];
		}

		return ['success' => true];
	}

	public function getActiveDmUserIds(): array
	{
		$rows = $this->db->table('user_campaign')
			->select('user_campaign.user_id')
			->join($this->table, 'campaign.id = user_campaign.campaign_id', 'inner')
			->where('user_campaign.is_dm', 1)
			->where('campaign.is_active', 1)
			->groupBy('user_campaign.user_id')
			->get()
			->getResult();

		$ids = [];
		foreach ($rows as $row) {
			$ids[] = (int) $row->user_id;
		}

		return $ids;
	}
}
