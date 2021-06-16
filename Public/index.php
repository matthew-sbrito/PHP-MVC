<?php

require_once(realpath(dirname(__FILE__,2) . '/config/config.php'));

use App\Controller\Pages\Home;
use App\Controller\Pages\Vagas;

Home::getHome();
Vagas::getVagas();