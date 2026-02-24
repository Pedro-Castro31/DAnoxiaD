<?php

namespace App\Controllers;

class CharacterSheetController extends BaseController
{
    public function index(): string
    {
        return view('pages/user_character_sheet', [
            'title' => 'Character Sheet | Anoxia',
        ]);
    }
}
