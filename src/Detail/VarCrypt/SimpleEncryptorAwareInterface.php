<?php

namespace Detail\VarCrypt;

interface SimpleEncryptorAwareInterface
{
    public function setEncryptor(SimpleEncryptor $encryptor);
}
