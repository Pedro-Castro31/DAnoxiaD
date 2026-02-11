<?php

namespace App\Controllers;

class Campaigns extends BaseController
{
    public function index(): string
    {
        $data = [
            'campaigns' => [],
            'db_status' => 'Connected',
        ];

        try {
            $db = \Config\Database::connect();
            $userId = (int) (session()->get('user_id') ?? 0);

            if ($userId <= 0) {
                $data['db_status'] = 'User not authenticated.';
                return view('pages/campaigns', $data);
            }

            if (! $db->tableExists('user_campaign') || ! $db->tableExists('campaign')) {
                $data['db_status'] = 'Required tables not found (user_campaign/campaign).';
                return view('pages/campaigns', $data);
            }

            $ucFields = $db->getFieldNames('user_campaign');
            $cFields = $db->getFieldNames('campaign');

            $campaignFk = $this->firstExistingField($ucFields, ['campaign_id', 'id_campaign']);
            if ($campaignFk === null) {
                $data['db_status'] = 'campaign relation field not found in user_campaign.';
                return view('pages/campaigns', $data);
            }

            $campaignNameField = $this->firstExistingField($cFields, ['name', 'title', 'campaign_name']) ?? 'id';
            $isActiveField = in_array('is_active', $cFields, true) ? 'is_active' : null;
            $isDmField = in_array('is_dm', $ucFields, true) ? 'is_dm' : null;

            $select = [
                'c.id AS campaign_id',
                "c.{$campaignNameField} AS campaign_name",
            ];
            if ($isActiveField !== null) {
                $select[] = 'c.is_active';
            }
            if ($isDmField !== null) {
                $select[] = 'uc.is_dm';
            }

            $rows = $db->table('user_campaign uc')
                ->select(implode(', ', $select))
                ->join('campaign c', "c.id = uc.{$campaignFk}", 'inner')
                ->where('uc.user_id', $userId)
                ->orderBy('c.id', 'DESC')
                ->get()
                ->getResult();

            foreach ($rows as $row) {
                $data['campaigns'][] = (object) [
                    'id' => (int) ($row->campaign_id ?? 0),
                    'name' => (string) ($row->campaign_name ?? ('Campaign #' . ($row->campaign_id ?? '?'))),
                    'is_active' => property_exists($row, 'is_active') ? (int) $row->is_active : null,
                    'is_dm' => property_exists($row, 'is_dm') ? (int) $row->is_dm : null,
                ];
            }
        } catch (\Throwable $e) {
            $data['db_status'] = 'Error: ' . $e->getMessage();
        }

        return view('pages/campaigns', $data);
    }

    /**
     * @param array<int, string> $available
     * @param array<int, string> $candidates
     */
    private function firstExistingField(array $available, array $candidates): ?string
    {
        foreach ($candidates as $field) {
            if (in_array($field, $available, true)) {
                return $field;
            }
        }

        return null;
    }
}
