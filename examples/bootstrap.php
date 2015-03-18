<?php

$loader = null;
$basePath = realpath(__DIR__ . '/..') . '/';

if (file_exists($basePath . 'vendor/autoload.php')) {
    $loader = include $basePath . 'vendor/autoload.php';
} else {
    throw new RuntimeException(
        $basePath . 'vendor/autoload.php could not be found. Did you run `php composer.phar install`?'
    );
}

$loader->add('Detail\VarCrypt', $basePath . 'src');

if (!file_exists(__DIR__ . '/config.php')) {
    throw new RuntimeException(
        'Missing configuration file "config.php"; make a copy of "config.php.dist" and update it'
    );
}

return require __DIR__ . '/config.php';
