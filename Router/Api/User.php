<?php

use \App\Http\Response;
use \App\Controller\Api;

//ROTA SOBRE
$router->get('/api/users',[
    function($request){
        return new Response(200,Api\UsersController::getAllUsers($request), 'application/json');
    }
]);
$router->get('/api/pages/users',[
    function($request){
        return new Response(200,Api\UsersController::getAllUsersWithPagination($request), 'application/json');
    }
]);
$router->get('/api/user/{id}',[
    function($request,$id){
        return new Response(200,Api\UsersController::getUserById($request,$id), 'application/json');
    }
]);
