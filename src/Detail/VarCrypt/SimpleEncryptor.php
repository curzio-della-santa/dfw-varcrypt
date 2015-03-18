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
        $encodedValue = $this->encode($value);
        $result = putenv("$name=$encodedValue");

        if ($result === false) {
            throw new Exception\RuntimeException(
                sprintf('Failed to set environment variable "%s"', $name)
            );
        }
    }

    /**
     * Decode and decrypt a previously set environment variable.
     *
     * @param string $name
     * @return string|null
     */
    public function getVariable($name)
    {
        $encodedValue = getenv($name);

        if ($encodedValue === false) {
            return null;
        }

        $value = $this->decode($encodedValue);

        return $value;
    }
}
