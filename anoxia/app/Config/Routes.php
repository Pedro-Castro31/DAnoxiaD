<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('login', 'Auth::showLogin');
$routes->post('auth/login', 'Auth::login');

$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('auth/logout', 'Auth::logout');
    $routes->get('auth/test', static function () {
        log_message('info', 'Test route hit');
        return 'Auth test route works!';
    });
});
