<?php

use \App\Http\Response;
use \App\Controller\Api;

//ROTA SOBRE
$router->get('/api/users',[
    'middlewares' =>[
        'api',
        'cache'
    ],
    function($request){
        return new Response(200,Api\UsersController::getAllUsers($request), 'application/json');
    }
]);
$router->get('/api/users/me',[
    'middlewares' =>[
        'api',
        'jwtAuth'
    ],
    function($request){
        return new Response(200,Api\UsersController::getCurrentUser($request), 'application/json');
    }
]);
$router->get('/api/pages/users',[
    'middlewares' =>[
        'api'
    ],
    function($request){
        return new Response(200,Api\UsersController::getAllUsersWithPagination($request), 'application/json');
    }
]);
$router->get('/api/user/{id}',[
    'middlewares' =>[
        'api'
    ],
    function($request,$id){
        return new Response(200,Api\UsersController::getUserById($request,$id), 'application/json');
    }
]);
$router->post('/api/user',[
    'middlewares' =>[
        'api',
    ],
    function($request){
        return new Response(201,Api\UsersController::setNewUser($request), 'application/json');
    }
]);

$router->put('/api/update/user/{id}',[
    'middlewares' =>[
        'api',
        'userBasicAuth',
    ],
    function($request, $id){
        return new Response(200,Api\UsersController::updateUser($request, $id), 'application/json');
    }
]);
$router->put('/api/update/password/{id}',[
    'middlewares' =>[
        'api',
        'userBasicAuth',
    ],
    function($request, $id){
        return new Response(200,Api\UsersController::updatePassword($request, $id), 'application/json');
    }
]);

$router->delete('/api/delete/user/{id}',[
    'middlewares' =>[
        'api',
        'userBasicAuth',
    ],
    function($request, $id){
        return new Response(200,Api\UsersController::deleteUser($request, $id), 'application/json');
    }
]);
