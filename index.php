<?php
    require('autoload.php');
    include_once(__DIR__ . '/env.php');
    include_once(__DIR__ . '/routes/api.php');

    if (!session_start()) {
        session_start();
    }

    // SETAR HORARIO DO SERVIDOR
    if (empty($_ENV['TIMEZONE'])) {
        echo "Configure a timezone no ENV";
        exit;    
    }

    $_SERVER['PROJECT_ROOT'] = realpath(__DIR__ . '/..');
    
    date_default_timezone_set($_ENV['TIMEZONE']);

    $Router = new Router();
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
    $Router->runApi($api);
?>