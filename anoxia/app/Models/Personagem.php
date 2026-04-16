<?php

namespace App\Models;

use CodeIgniter\Model;

class Personagem extends Model
{
    protected $table      = 'personagens';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'campaign_id',
        'character_name',
        'player_name',
        'race',
        'class',
        'level',
        'background',
        'hp_current',
        'hp_max',
        'ability_scores',
        'notes',
    ];

    public function getAllWithCampaign(): array
    {
        return $this->select('personagens.*, campaign.name AS campaign_name')
            ->join('campaign', 'campaign.id = personagens.campaign_id', 'left')
            ->orderBy('personagens.character_name', 'ASC')
            ->findAll();
    }

    public function createPersonagem(array $data): array
    {
        if (isset($data['ability_scores']) && is_array($data['ability_scores'])) {
            $data['ability_scores'] = json_encode($data['ability_scores']);
        }

        $id = $this->insert($data, true);
        if ($id === false) {
            return ['success' => false, 'error' => implode(', ', $this->errors())];
        }

        return ['success' => true, 'id' => $id];
    }
}
