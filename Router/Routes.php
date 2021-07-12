<?php

use \App\Http\Response;
use \App\Controller;


//ROTA HOME 
$router->get('/',[
    function($request){
        return new Response(200,Controller\HomeController::goHome($request));
    }
]);

$router->get('/home',[
    function($request){
        return new Response(200,Controller\HomeController::getHome($request));
    }
]);

//ROTA SOBRE
$router->get('/about',[
    function(){
        return new Response(200,Controller\AboutController::getAbout());
    }
]);

//ROTA DINÂMICA
$router->get('/page/{idPage}/{action}',[
    function($idPage, $action){
        return new Response(200, 'Page' . $idPage. ' - ' . $action);
    }
]);