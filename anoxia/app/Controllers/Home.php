<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Campaign;

class Home extends BaseController
{
    public function index(): string
    {
        $userModel = new User();
        $campaignModel = new Campaign();

        try {
            $counts = $userModel->getDashboardCounts();
            $campaignResult = $campaignModel->getFilteredWithDm('', null, null, 1, 4);
            $recentCampaigns = $campaignResult['items'];
            $totalCampaigns  = $campaignResult['total'];
        } catch (\Throwable $e) {
            $counts          = ['total' => 0, 'active' => 0, 'admin' => 0, 'dm' => 0, 'pending' => 0, 'inactive' => 0];
            $recentCampaigns = [];
            $totalCampaigns  = 0;
        }

        return view('pages/home', [
            'totalUsers'      => $counts['total'],
            'activeUsers'     => $counts['active'],
            'totalCampaigns'  => $totalCampaigns,
            'recentCampaigns' => $recentCampaigns,
        ]);
    }
}
