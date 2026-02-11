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

	public function getAllWithDm(): array
	{
		$result = $this->getFilteredWithDm('', null, null, 1, 5000);
		return $result['items'];
	}

	/**
	 * @return array{items: array<int, object>, total: int, page: int, perPage: int}
	 */
	public function getFilteredWithDm(string $search, ?int $dmUserId, ?int $isActive, int $page, int $perPage): array
	{
		$page = max(1, $page);
		$perPage = max(1, $perPage);
		$offset = ($page - 1) * $perPage;

		$base = $this->baseFilteredBuilder($search, $dmUserId, $isActive);
		$totalRow = (clone $base)
			->select('COUNT(DISTINCT campaign.id) AS total', false)
			->get()
			->getRow();
		$total = (int) ($totalRow->total ?? 0);

		$campaigns = (clone $base)
			->select('campaign.id, campaign.name, campaign.description, campaign.img_path, campaign.is_active')
			->groupBy('campaign.id')
			->orderBy('campaign.id', 'DESC')
			->limit($perPage, $offset)
			->get()
			->getResult();

		if (empty($campaigns)) {
			return [
				'items' => [],
				'total' => $total,
				'page' => $page,
				'perPage' => $perPage,
			];
		}

		$campaignIds = [];
		foreach ($campaigns as $campaign) {
			$campaignIds[] = (int) $campaign->id;
		}

		$userModel = new User();
		$userTable = $userModel->getUserTable();

		$dmRows = $this->db->table('user_campaign')
			->select('user_campaign.campaign_id, u.name')
			->join($this->table, 'campaign.id = user_campaign.campaign_id', 'inner')
			->join($userTable . ' u', 'u.id = user_campaign.user_id', 'inner')
			->whereIn('user_campaign.campaign_id', $campaignIds)
			->where('user_campaign.is_dm', 1)
			->orderBy('u.name', 'asc')
			->get()
			->getResult();

		$dmMap = [];
		foreach ($dmRows as $row) {
			$campaignId = (int) $row->campaign_id;
			$dmMap[$campaignId][] = $row->name;
		}

		foreach ($campaigns as $campaign) {
			$names = $dmMap[(int) $campaign->id] ?? [];
			$campaign->dm_names = $names;
			$campaign->dm_label = $names ? implode(' & ', $names) : 'N/A';
		}

		return [
			'items' => $campaigns,
			'total' => $total,
			'page' => $page,
			'perPage' => $perPage,
		];
	}

	public function getDmOptions(): array
	{
		$userModel = new User();
		$userTable = $userModel->getUserTable();

		return $this->db->table('user_campaign uc')
			->select('u.id, u.name, u.email')
			->join($userTable . ' u', 'u.id = uc.user_id', 'inner')
			->where('uc.is_dm', 1)
			->groupBy('u.id')
			->orderBy('u.name', 'ASC')
			->get()
			->getResult();
	}

	private function baseFilteredBuilder(string $search, ?int $dmUserId, ?int $isActive): \CodeIgniter\Database\BaseBuilder
	{
		$builder = $this->db->table($this->table);

		if ($search !== '') {
			$builder->groupStart()
				->like('campaign.name', $search)
				->orLike('campaign.description', $search)
				->groupEnd();
		}

		if ($isActive !== null) {
			$builder->where('campaign.is_active', $isActive);
		}

		if ($dmUserId !== null) {
			$builder->join('user_campaign uc_filter', 'uc_filter.campaign_id = campaign.id', 'inner');
			$builder->where('uc_filter.is_dm', 1);
			$builder->where('uc_filter.user_id', $dmUserId);
		}

		return $builder;
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
