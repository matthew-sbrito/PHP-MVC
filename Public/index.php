<?php

require_once(realpath(dirname(__FILE__,2) . '/config/config.php'));

use \App\Http\Router;
use \App\Http\Response;
use \App\Controller\Pages\Home;

define('URL','http://www.modelo.com/');

$obRouter = new Router(URL);

//ROTA HOME 
$obRouter->get('/',[
    function(){
        return new Response(200,Home::getHome());
    }
]);

$obRouter->run()
         ->sendResponse();