<?php

namespace Detail\VarCrypt;

use Keboola\Encryption;

class SimpleEncryptor
{
    /**
     * @var Encryption\EncryptorInterface
     */
    protected $encryptor;

    /**
     * @param Encryption\EncryptorInterface $encryptor
     */
    public function __construct(Encryption\EncryptorInterface $encryptor)
    {
        $this->setEncryptor($encryptor);
    }

    /**
     * @return Encryption\EncryptorInterface
     */
    public function getEncryptor()
    {
        return $this->encryptor;
    }

    /**
     * @param Encryption\EncryptorInterface $encryptor
     */
    public function setEncryptor(Encryption\EncryptorInterface $encryptor)
    {
        $this->encryptor = $encryptor;
    }

    /**
     * @param string $name
     * @return string|null
     */
    public function getVariable($name)
    {
        $encryptedValue = getenv($name);

        if ($encryptedValue === false) {
            return null;
        }

        $value = $this->getEncryptor()->decrypt($encryptedValue);

        return $value;
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function setVariable($name, $value)
    {
        $encryptedValue = $this->getEncryptor()->encrypt($value);

        $result = putenv("$name=$encryptedValue");

        if ($result === false) {
            throw new Exception\RuntimeException(
                sprintf('Failed to set environment variable "%s"', $name)
            );
        }
    }
}
