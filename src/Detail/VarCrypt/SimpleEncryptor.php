<?php

namespace Detail\VarCrypt;

use Keboola\Encryption;

class SimpleEncryptor extends BaseEncryptor
{
    /**
     * Set an encrypted and base64 encoded environment variable.
     *
     * @param string $name
     * @param string $value
     */
    public function setVariable($name, $value)
    {
        $this->setEnvironmentVariable($name, $this->encode($value));
    }

    /**
     * Decode and decrypt a previously set environment variable.
     *
     * @param string $name
     * @return string|null
     */
    public function getVariable($name)
    {
        return $this->decode($this->getEnvironmentVariable($name));
    }
}
