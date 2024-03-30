<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('api', function () use ($routes) {
    $routes->post('regenerate_token', 'Token::regenerateToken');
    $routes->group('auth', function () use ($routes) {
        $routes->post('register', 'Auth::register');
        $routes->post('login', 'Auth::login');
        $routes->post('verify-email', 'Auth::verifyEmail');
    });
    $routes->get('profile',function(){
        try {
        $user = validateJWT(getJWTFromRequest(request()->getHeaderLine('Authorization')));
        return response()->setJSON(["user"=>['email'=>$user['email']]]);
        }
        catch (Exception $ex){
            return response()->setJSON(["error"=>$ex->getMessage()]);
        }
    }, ['filter'=>'auth']);
});