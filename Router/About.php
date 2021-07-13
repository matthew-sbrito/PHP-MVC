<?php

use \App\Http\Response;
use \App\Controller\Pages;

//ROTA SOBRE
$router->get('/about',[
    function(){
        return new Response(200,Pages\AboutController::getAbout());
    }
]);
