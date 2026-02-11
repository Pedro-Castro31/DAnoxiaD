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


$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('auth/logout', 'Auth::logout');
    $routes->get('auth/test', static function () {
        log_message('info', 'Test route hit');
        return 'Auth test route works!';
    });
});
