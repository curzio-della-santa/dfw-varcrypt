<?php

use Keboola\Encryption;
use Detail\VarCrypt\SimpleEncryptor;

$config = require 'bootstrap.php';

$getConfig = function($optionName) use ($config) {
    if (!isset($config[$optionName])) {
        throw new RuntimeException(sprintf('Missing configuration option "%s"', $optionName));
    }

    return $config[$optionName];
};

$encryptor = new SimpleEncryptor(new Encryption\AesEncryptor($getConfig('key')));
$encryptor->setVariable('TEST', 'Unencrypted value');

printf("TEST: %s\n", $encryptor->getVariable('TEST'));
