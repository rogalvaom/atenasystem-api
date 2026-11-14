<?php
spl_autoload_register(function ($className) {
    $baseDirs = [
        __DIR__ . '/src/base/',
        __DIR__ . '/src/controller/',  
        __DIR__ . '/src/model/',
        __DIR__ . '/src/middleware/',
        __DIR__ . '/src/request/',      
    ];

    foreach ($baseDirs as $baseDir) {
        $file = $baseDir . $className . '.php';

        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }

    throw new Exception("Classe '{$className}' não encontrada no autoload.");
});
