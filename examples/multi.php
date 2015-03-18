<?php

use Keboola\Encryption;
use Detail\VarCrypt\MultiEncryptor;

$config = require 'bootstrap.php';

$getConfig = function($optionName) use ($config) {
    if (!isset($config[$optionName])) {
        throw new RuntimeException(sprintf('Missing configuration option "%s"', $optionName));
    }

    return $config[$optionName];
};

$variables = array(
    'password' => 'unencrypted_mysql_password',
    'port' => 3306,
);

$encryptor = new MultiEncryptor(new Encryption\AesEncryptor($getConfig('key')));
$encryptor->setVariables('mysql', $variables);

printf("MYSQL_PASSWORD: %s\n", $encryptor->getVariable('mysql', 'password'));

$encryptor->applyVariables(array('mysql'));

printf("MYSQL_PORT: %s\n", getenv('MYSQL_PORT'));
