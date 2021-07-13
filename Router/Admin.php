<?php

use \App\Http\Response;
use \App\Controller\Admin\AdminController;
use \App\Controller\Admin\LoginController;

//ROTA HOME 
$router->get('/admin',[
    function($request){
        return new Response(200,AdminController::getView($request));
    }
]);

$router->get('/admin/login',[
    function($request){
        return new Response(200,LoginController::getViewLogin($request));
    }
]);

$router->post('/admin/login',[
    function($request){
        return new Response(200,LoginController::authenticatedLogin($request));
    }
]);
