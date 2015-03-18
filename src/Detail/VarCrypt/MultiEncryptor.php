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
     * Apply group's values as individual, plain environment variables.
     *
     * The group name prefixes the variable name (joined by the separator).
     *
     * @param array|string $groups
     * @param string $separator
     */
    public function applyVariables($groups, $separator = '_')
    {
        if (!is_array($groups)) {
            $groups = array($groups);
        }

        foreach ($groups as $group) {
            $values = $this->getVariables($group);

            foreach ($values as $variable => $value) {
                $name = $group . $separator . $variable;

                $this->setEnvironmentVariable($name, $value);
            }
        }
    }

    /**
     * Set values as an encrypted and base64 encoded environment variable.
     *
     * @param string $group
     * @param array $values
     */
    public function setVariables($group, array $values)
    {
        $this->setEnvironmentVariable($group, $this->encode($values));
    }

    /**
     * Decode and decrypt values from a previously set environment variable.
     *
     * @param string $group
     * @return array
     */
    public function getVariables($group)
    {
        $encodedValues = $this->getEnvironmentVariable($group);

        if ($encodedValues === null) {
            return null;
        }

        return $this->decode($encodedValues);
    }

    /**
     * Decode and decrypt a single value from a previously set environment variable.
     *
     * @param string $group
     * @param string $name
     * @return mixed|null
     */
    public function getVariable($group, $name)
    {
        $variables = $this->getVariables($group);

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
