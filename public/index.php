<?php
session_start();
require_once(realpath(dirname(__FILE__,2) . '/config/config.php'));

use \App\Http\Router;
use \App\Utils\View;
use \App\Http\Middleware\Queue as Middleware;

//DEFINE O VALOR PADRÃO DAS VARIÁVEIS
View::init([
    'URL' => URL
]);

//MAPEAMENTO DOS MIDDLEWARES
Middleware::setMap([
 'maintenance'         => \App\Http\Middleware\Maintenance::class,
 'authenticatedUser'   => \App\Http\Middleware\AuthenticatedUser::class,
 'authenticatedAdmin'  => \App\Http\Middleware\AuthenticatedAdmin::class,
 'checkLogged'         => \App\Http\Middleware\CheckLogged::class,
 'api'                 => \App\Http\Middleware\Api::class,
 'userBasicAuth'       => \App\Http\Middleware\UserBasicAuth::class,
 'jwtAuth'             => \App\Http\Middleware\JWTAuth::class,
 'cache'               => \App\Http\Middleware\Cache::class,
]);

//MIDDLEWARES PADRÕES (EXECUTADOS EM TODAS AS ROTAS)
Middleware::setDefault([
 'maintenance',
]);

// INICIA O ROUTER
$router = new Router(URL);

//INCLUDE PARA AS ROTAS
include(realpath(dirname(__FILE__,2) . '/router/routes.php'));

//IMPRIME O RESPONSE DA ROTA

$router->run()
         ->sendResponse();