<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require(__DIR__ . '/autoload.php');
    @include_once(__DIR__ . '/env.php');
    include_once(__DIR__ . '/routes/api.php');

    if (session_status() === PHP_SESSION_NONE) {
        @session_start();
    }

    if (!empty($_ENV['TIMEZONE'])) {
        @date_default_timezone_set($_ENV['TIMEZONE']);
    }

    $_SERVER['PROJECT_ROOT'] = @realpath(__DIR__ . '/..') ?: __DIR__;

    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $Router = new Router();
    $Router->runApi($api);
?>