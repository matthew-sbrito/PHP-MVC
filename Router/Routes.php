<?php

use \App\Http\Response;
use \App\Controller;

include('Home.php');
include('About.php');
include('Admin.php');           
include('Api/User.php');           

//ROTA DINÂMICA
$router->get('/page/{idPage}/{action}',[
    function($idPage, $action){
        return new Response(200, 'Page' . $idPage. ' - ' . $action);
    }
]);