<?php

namespace App\Models;

use CodeIgniter\Model;

class AbilityScoreConfig extends Model
{
    protected $table      = 'ability_score_config';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'score_key',
        'label',
        'abbr',
        'sort_order',
    ];

    /**
     * All ability scores in display order.
     * @return array<int, object>
     */
    public function getOrdered(): array
    {
        return $this->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC')->findAll();
    }

    /**
     * Replace the entire ability score config in a single transaction.
     * Keys are preserved when still present, so existing character data stays valid.
     *
     * @param array<int, array{score_key: string, label: string, abbr?: string|null}> $rows
     */
    public function replaceAll(array $rows): bool
    {
        $db = $this->db;
        $db->transStart();
        $db->table($this->table)->truncate();

        $now = date('Y-m-d H:i:s');
        $order = 0;
        $batch = [];
        foreach ($rows as $row) {
            $batch[] = [
                'score_key'  => $row['score_key'],
                'label'      => $row['label'],
                'abbr'       => $row['abbr'] ?? null,
                'sort_order' => $order++,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        if (!empty($batch)) {
            $db->table($this->table)->insertBatch($batch);
        }

        $db->transComplete();
        return $db->transStatus() !== false;
    }
}
