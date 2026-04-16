<?php

namespace App\Controllers;

use App\Models\Campaign;
use App\Models\Personagem;
use Config\CharacterSheet;

class PersonagemManager extends BaseController
{
    public function index(): string
    {
        $model = new Personagem();
        $campaignModel = new Campaign();
        $config = new CharacterSheet();

        $personagens = $model->getAllWithCampaign();
        $campaigns = $campaignModel->getAll();

        return view('pages/personagens', [
            'personagens'   => $personagens,
            'campaigns'     => $campaigns,
            'abilityScores' => $config->abilityScores,
        ]);
    }

    public function create()
    {
        $rules = [
            'character_name' => 'required|min_length[2]|max_length[120]',
            'level'          => 'required|integer|greater_than[0]|less_than_equal_to[20]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('personagem_error', 'Dados inválidos.');
        }

        $config = new CharacterSheet();
        $scores = [];
        foreach ($config->abilityScores as $score) {
            $key = $score['key'];
            $val = (int) ($this->request->getPost('ability_' . $key) ?? 10);
            $scores[$key] = max(1, min(30, $val));
        }

        $campaignId = $this->request->getPost('campaign_id');

        $data = [
            'character_name' => $this->request->getPost('character_name'),
            'player_name'    => $this->request->getPost('player_name') ?: null,
            'race'           => $this->request->getPost('race') ?: null,
            'class'          => $this->request->getPost('class') ?: null,
            'level'          => (int) $this->request->getPost('level'),
            'background'     => $this->request->getPost('background') ?: null,
            'hp_current'     => (int) ($this->request->getPost('hp_current') ?? 0),
            'hp_max'         => (int) ($this->request->getPost('hp_max') ?? 0),
            'ability_scores' => $scores,
            'notes'          => $this->request->getPost('notes') ?: null,
            'campaign_id'    => is_numeric($campaignId) && (int) $campaignId > 0 ? (int) $campaignId : null,
        ];

        $model = new Personagem();
        $result = $model->createPersonagem($data);

        if (!$result['success']) {
            return redirect()->back()->withInput()->with('personagem_error', $result['error']);
        }

        return redirect()->to(base_url('personagens'))->with('personagem_info', 'Personagem criada com sucesso.');
    }
}
