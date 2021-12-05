<?php

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");  

require_once __DIR__ . '/../helpers/paths.php';
require_once __DIR__ . '/../vendor/autoload.php';

use App\Utils\Environment;
use App\Database\Database;
use App\Http\Middleware\Queue as Middleware;

//CARREGA VÁRIAVEIS DE AMBIENTE
Environment::load(__DIR__ . '/../');

// CONSTANTES GLOBAIS
define('URL', getenv('URL'));
define('API_SERVER', getenv('API_SERVER'));
define('RESOURCES', '/../resources');
define('VIEWS', RESOURCES . '/views');
define('ASSETS', RESOURCES . '/assets');

// DATABASE CONFIG
Database::config(config('database'));

//MAPEAMENTO DOS MIDDLEWARES
$middlewares = config('middlewares');
Middleware::setMap($middlewares['middlewares']);

//MIDDLEWARES PADRÕES (EXECUTADOS EM TODAS AS ROTAS)
Middleware::setDefault($middlewares['default']);

// INCLUDE FOR SERVER WEBSOCKET
config('websocket.server');
