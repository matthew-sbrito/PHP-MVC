<?php

use \App\Http\Response;
use \App\Controller\Pages;


//ROTA HOME 
$obRouter->get('/',[
    function(){
        return new Response(200,Pages\Home::getHome());
    }
]);

$obRouter->get('/home',[
    function(){
        return new Response(200,Pages\Home::getHome());
    }
]);

//ROTA SOBRE
$obRouter->get('/about',[
    function(){
        return new Response(200,Pages\About::getAbout());
    }
]);

//ROTA DINÂMICA
$obRouter->get('/page/{idPage}/{action}',[
    function($idPage, $action){
        return new Response(200, 'Page' . $idPage. ' - ' . $action);
    }
]);