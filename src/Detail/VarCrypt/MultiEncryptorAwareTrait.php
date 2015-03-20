<?php

namespace Detail\VarCrypt;

trait MultiEncryptorAwareTrait
{
    /**
     * @var  MultiEncryptor
     */
    protected $encryptor;

    /**
     * @return MultiEncryptor
     */
    public function getEncryptor()
    {
        return $this->encryptor;
    }

    /**
     * @param MultiEncryptor $encryptor
     */
    public function setEncryptor(MultiEncryptor $encryptor)
    {
        $this->encryptor = $encryptor;
    }
}
