<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('login', 'Auth::showLogin');
$routes->post('auth/login', 'Auth::login');
$routes->post('auth/recover', 'Auth::recoverPassword');
$routes->get('auth/reset-password', 'Auth::resetPassword');
$routes->post('auth/reset-password', 'Auth::resetPassword');
$routes->get('dashboardtest', 'UserManager::index');
$routes->get('campaigntest', 'CampaignManager::index');
$routes->post('admin/users/create', 'UserManager::create');
$routes->post('campaigns/create', 'CampaignManager::create');

$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('auth/logout', 'Auth::logout');
});
