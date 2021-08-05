<?php

use \App\Http\Response;
use \App\Controller\Api;

//ROTA SOBRE
$router->post('/api/auth',[
    'middlewares' =>[
        'api'
    ],
    function($request){
        return new Response(201,Api\AuthController::generateToken($request), 'application/json');
    }
]);