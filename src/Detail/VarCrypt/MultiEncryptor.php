<?php

namespace Detail\VarCrypt;

use Keboola\Encryption;

/**
 * MultiEncryptor.
 *
 * Use this class to write key/value pairs as encrypted and base64 encoded environment variables.
 *
 * @package Detail\VarCrypt
 */
class MultiEncryptor extends BaseEncryptor
{
    /**
     * Set values as an encrypted and base64 encoded environment variable.
     *
     * @param string $groupName
     * @param array $values
     */
    public function setVariables($groupName, array $values)
    {
        $this->setEnvironmentVariable($groupName, $this->encode($values));
    }

    /**
     * Decode and decrypt values from a previously set environment variable.
     *
     * @param string $groupName
     * @return array
     */
    public function getVariables($groupName)
    {
        $encodedValues = $this->getEnvironmentVariable($groupName);

        if ($encodedValues === null) {
            return null;
        }

        return $this->decode($encodedValues);
    }

    /**
     * Decode and decrypt a single value from a previously set environment variable.
     *
     * @param string $groupName
     * @param string $name
     * @return mixed|null
     */
    public function getVariable($groupName, $name)
    {
        $variables = $this->getVariables($groupName);

        return array_key_exists($name, $variables) ? $variables[$name] : null;
    }

    /**
     * Encrypt and encode group values.
     *
     * @param array $values
     * @return string
     */
    public function encode($values)
    {
        $json = json_encode($values);

        $this->handleJsonError('Failed to encode group values to JSON');

        return parent::encode($json);
    }

    /**
     * Decode and decrypt group values.
     *
     * @param string $value
     * @return array
     */
    public function decode($value)
    {
        $json = parent::decode($value);

        $values = json_decode($json, true);

        $this->handleJsonError('Failed to decode group values from JSON');

        return $values;
    }

    /**
     * @param string $errorMessage
     */
    private function handleJsonError($errorMessage)
    {
        $error = json_last_error();

        if ($error !== JSON_ERROR_NONE) {
            switch (json_last_error()) {
                case JSON_ERROR_DEPTH:
                    $message = 'Maximum stack depth exceeded';
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    $message = 'Underflow or the modes mismatch';
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    $message = 'Unexpected control character found';
                    break;
                case JSON_ERROR_SYNTAX:
                    $message = 'Syntax error, malformed JSON';
                    break;
                case JSON_ERROR_UTF8:
                    $message = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                    break;
                default:
                    $message = 'Unknown error';
                    break;
            }

            throw new Exception\RuntimeException(
                $errorMessage . '; ' . $message
            );
        }
    }
}
