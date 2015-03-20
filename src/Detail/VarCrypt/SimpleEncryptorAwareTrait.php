<?php

namespace Detail\VarCrypt;

trait SimpleEncryptorAwareTrait
{
    /**
     * @var  SimpleEncryptor
     */
    protected $encryptor;

    /**
     * @return SimpleEncryptor
     */
    public function getEncryptor()
    {
        return $this->encryptor;
    }

    /**
     * @param SimpleEncryptor $encryptor
     */
    public function setEncryptor(SimpleEncryptor $encryptor)
    {
        $this->encryptor = $encryptor;
    }
}
