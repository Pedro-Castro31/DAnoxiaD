<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('theme_war_room');
    }
}
