<?php

use \App\Http\Response;
use \App\Controller\Admin\UsersController;
use \App\Controller\Admin\LoginController;
use \App\Controller\Admin\HomeController;

//ROTA HOME 
$router->get('/admin/users',[
    'middlewares' => [
        'authenticatedAdmin' 
    ], 
    function($request){
        return new Response(200,UsersController::getView($request));
    }
]);

$router->get('/admin/login',[
    'middlewares' => [
        'checkLogged'
    ],
    function($request){
        return new Response(200,LoginController::getViewLogin($request));
    }
]);

$router->get('/admin/home',[
    'middlewares' => [
        'authenticatedAdmin'
    ],
    function($request){
        return new Response(200,HomeController::getView($request));
    }
]);


$router->post('/admin/login',[
    function($request){
        return new Response(200,LoginController::authenticatedLogin($request));
    }
]);

$router->get('/logout',[
    function($request){
        return new Response(200,LoginController::logout($request));
    }
]);
