<?php

namespace App\Controllers;

use App\Models\AbilityScoreConfig;
use App\Models\User;

class Settings extends BaseController
{
    private const VALID_THEMES = ['medieval', 'white', 'dark', 'carbonfox', 'ember'];

    public function updateTheme()
    {
        $theme = (string) $this->request->getPost('theme');

        if (!in_array($theme, self::VALID_THEMES, true)) {
            return redirect()->back();
        }

        $userId = (int) session()->get('user_id');
        if ($userId <= 0) {
            return redirect()->to(base_url('login'));
        }

        $userModel = new User();
        $userModel->updateTheme($userId, $theme);
        session()->set('user_theme', $theme);

        return redirect()->back();
    }

    public function characterSheet(): string
    {
        $model = new AbilityScoreConfig();
        return view('pages/settings_character_sheet', [
            'abilityScores' => $model->getOrdered(),
        ]);
    }

    public function updateCharacterSheet()
    {
        $rows = $this->request->getPost('scores');
        if (!is_array($rows) || empty($rows)) {
            return redirect()->back()->with('settings_error', 'Precisas de pelo menos um atributo.');
        }

        $seenKeys = [];
        $normalised = [];

        foreach ($rows as $row) {
            if (!is_array($row)) {
                continue;
            }
            $label = trim((string) ($row['label'] ?? ''));
            if ($label === '') {
                continue;
            }

            $key = trim((string) ($row['key'] ?? ''));
            if ($key === '') {
                $key = self::slugify($label);
            } else {
                $key = self::slugify($key);
            }
            if ($key === '') {
                $key = 'attr';
            }

            $baseKey = $key;
            $suffix  = 2;
            while (isset($seenKeys[$key])) {
                $key = $baseKey . '_' . $suffix++;
            }
            $seenKeys[$key] = true;

            $abbr = trim((string) ($row['abbr'] ?? ''));
            if ($abbr === '') {
                $abbr = mb_strtoupper(mb_substr($label, 0, 3));
            } else {
                $abbr = mb_strtoupper(mb_substr($abbr, 0, 6));
            }

            $normalised[] = [
                'score_key' => $key,
                'label'     => mb_substr($label, 0, 80),
                'abbr'      => $abbr,
            ];
        }

        if (empty($normalised)) {
            return redirect()->back()->with('settings_error', 'Precisas de pelo menos um atributo válido.');
        }

        $model = new AbilityScoreConfig();
        if (!$model->replaceAll($normalised)) {
            return redirect()->back()->with('settings_error', 'Falha ao guardar a configuração.');
        }

        return redirect()->to(base_url('settings/character-sheet'))
            ->with('settings_info', 'Configuração de atributos atualizada.');
    }

    private static function slugify(string $value): string
    {
        $value = mb_strtolower($value);
        $value = strtr($value, [
            'á' => 'a', 'à' => 'a', 'ã' => 'a', 'â' => 'a', 'ä' => 'a',
            'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
            'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i',
            'ó' => 'o', 'ò' => 'o', 'õ' => 'o', 'ô' => 'o', 'ö' => 'o',
            'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u',
            'ç' => 'c', 'ñ' => 'n',
        ]);
        $value = preg_replace('/[^a-z0-9]+/', '_', $value) ?? '';
        return trim($value, '_');
    }
}
