<?php

require_once(realpath(dirname(__FILE__, 2) . '/vendor/autoload.php'));

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");  

define('TEMPLATE_PATH', realpath(dirname(__FILE__,2). '/resources/views/templates'));

use App\Utils\Environment;
use App\Database\Database;

//CARREGA VÁRIAVEIS DE AMBIENTE
$envPath = realpath(dirname(__FILE__,2));
Environment::load($envPath);

define('URL', getenv('URL'));
define('API_SERVER', getenv('API_SERVER'));

Database::config(
  getenv('DB_HOST'),
  getenv('DB_NAME'),
  getenv('DB_USER'),
  getenv('DB_PASSWORD'),
);
