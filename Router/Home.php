<?php

use \App\Http\Response;
use \App\Controller\Pages;

//ROTA HOME 
$router->get('/',[
    function($request){
        return new Response(200,Pages\HomeController::goHome($request));
    }
]);

$router->get('/home',[
    function($request){
        return new Response(200,Pages\HomeController::getHome($request));
    }
]);
