<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require('autoload.php');
    include_once('env.php');
    include_once('routes/web.php');
    include_once('routes/api.php');

    if (!session_start()) {
        session_start();
    }

    // SETAR HORARIO DO SERVIDOR
    if (empty($_ENV['TIMEZONE'])) {
        echo "Configure a timezone no ENV";
        exit;    
    }

    $_SERVER['PROJECT_ROOT'] = realpath(__DIR__);
    
    date_default_timezone_set($_ENV['TIMEZONE']);

    $Router = new Router();
    if ($Router->checkApi() ){
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        $Router->runApi($api);
    } else {
        $Router->runWeb($web);
    }
?>