<?php
session_start();

require_once __DIR__ . '/config/config.php';

use \App\Http\Router;
use \App\Utils\View;
use \App\Http\Middleware\Queue as Middleware;

//DEFINE O VALOR PADRÃO DAS VARIÁVEIS
View::init(config('views'));

//MIDDLEWARES PADRÕES (EXECUTADOS EM TODAS AS ROTAS)
Middleware::setDefault([
 'maintenance',
]);

// INICIA O ROUTER
$router = new Router(URL);

//INCLUDE PARA AS ROTAS
include __DIR__ . '/router/routes.php';

//IMPRIME O RESPONSE DA ROTA
$router->run()
         ->sendResponse();