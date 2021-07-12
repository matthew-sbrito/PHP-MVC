<?php
session_start();
require_once(realpath(dirname(__FILE__,2) . '/config/config.php'));

use \App\Http\Router;
use \App\Utils\View;
use \App\Utils\Environment;

//DEFINE O VALOR PADRÃO DAS VARIÁVEIS
View::init([
    'URL' => URL
]);

// INICIA O ROUTER
$router = new Router(URL);

//INCLUDE PARA AS ROTAS
include(realpath(dirname(__FILE__,2) . '/Router/Routes.php'));

//IMPRIME O RESPONSE DA ROTA

$router->run()
         ->sendResponse();