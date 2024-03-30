<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('api', function () use ($routes) {

    $routes->post('regenerate_token', 'Token::regenerateToken');
    
    //delete on production
    $routes->options('regenerate_token', function () {}, ['filter' => 'cors']);
    
    $routes->group('auth', function () use ($routes) {
        $routes->post('register', 'Auth::register');
        $routes->post('login', 'Auth::login');
        $routes->post('verify-email', 'Auth::verifyEmail');

        //delete on production
        $routes->options('login', function () {}, ['filter' => 'cors']);
        $routes->options('register', function () {}, ['filter' => 'cors']);
        $routes->options('verify-email', function () {}, ['filter' => 'cors']);
    });
    $routes->get('profile', 'User::index', ['filter' => 'auth']);
});
