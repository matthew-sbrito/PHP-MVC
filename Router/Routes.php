<?php

use \App\Http\Response;
use \App\Controller;


//ROTA HOME 
$obRouter->get('/',[
    function(){
        return new Response(200,Controller\HomeController::getHome());
    }
]);

$obRouter->get('/home',[
    function(){
        return new Response(200,Controller\HomeController::getHome());
    }
]);

//ROTA SOBRE
$obRouter->get('/about',[
    function(){
        return new Response(200,Controller\AboutController::getAbout());
    }
]);

//ROTA DINÂMICA
$obRouter->get('/page/{idPage}/{action}',[
    function($idPage, $action){
        return new Response(200, 'Page' . $idPage. ' - ' . $action);
    }
]);