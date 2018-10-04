<?php

if (! function_exists('encrypt')) {
    /**
     * Encrypt the given value.
     *
     * @param  string  $value
     * @param  string  $secret
     * @return string
     */
    function encrypt($value, $secret)
    {
        $encrypter = new \mradang\Encryption\Encrypter($secret);
        return $encrypter->encrypt($value);
    }
}

if (! function_exists('decrypt')) {
    /**
     * Decrypt the given value.
     *
     * @param  string  $value
     * @param  string  $secret
     * @return string
     */
    function decrypt($value, $secret)
    {
        $encrypter = new \mradang\Encryption\Encrypter($secret);
        return $encrypter->decrypt($value);
    }
}
