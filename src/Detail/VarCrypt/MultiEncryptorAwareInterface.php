<?php

namespace Detail\VarCrypt;

interface MultiEncryptorAwareInterface
{
    public function setEncryptor(MultiEncryptor $encryptor);
}
