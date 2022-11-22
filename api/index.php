<?php

ini_set('max_execution_time', 0);
set_time_limit(0);
date_default_timezone_set('America/Sao_Paulo');
ini_set('memory_limit', '1024M');

setlocale(LC_TIME, 'pt-br');

require_once 'vendor/autoload.php';
require_once 'Configs/dataBase.php';
require_once 'Src/slimConfiguracao.php';
require_once 'Src/startDB.php';
require_once 'Routes/index.php';
