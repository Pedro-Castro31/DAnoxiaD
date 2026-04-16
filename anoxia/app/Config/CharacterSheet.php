<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * CharacterSheet — defaults reference only.
 *
 * The runtime source for ability scores is the `ability_score_config` DB table,
 * editable from the in-app settings page at /settings/character-sheet.
 *
 * These defaults are used by the migration to seed the table on first run.
 */
class CharacterSheet extends BaseConfig
{
    /**
     * @var array<int, array{key: string, label: string, abbr: string}>
     */
    public array $defaultAbilityScores = [
        ['key' => 'strength',     'label' => 'Força',         'abbr' => 'FOR'],
        ['key' => 'dexterity',    'label' => 'Destreza',      'abbr' => 'DES'],
        ['key' => 'constitution', 'label' => 'Constituição',  'abbr' => 'CON'],
        ['key' => 'intelligence', 'label' => 'Inteligência',  'abbr' => 'INT'],
        ['key' => 'wisdom',       'label' => 'Sabedoria',     'abbr' => 'SAB'],
        ['key' => 'charisma',     'label' => 'Carisma',       'abbr' => 'CAR'],
    ];
}
