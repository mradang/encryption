<?php

namespace mradang\Encryption;

class Encrypter {

    private $key;

    private $cipher;

    public function __construct($key, $cipher = 'AES-256-CBC') {
        $key = (string) $key;

        if ($this->supported($key, $cipher)) {
            $this->key = $key;
            $this->cipher = $cipher;
        } else {
            throw new \Exception('The only supported ciphers are AES-128-CBC and AES-256-CBC with the correct key lengths.');
        }
    }

    private function supported($key, $cipher) {
        $length = mb_strlen($key, '8bit');

        return ($cipher === 'AES-128-CBC' && $length === 16) ||
               ($cipher === 'AES-256-CBC' && $length === 32);
    }

    public function encrypt(string $value) {
        $iv = random_bytes(openssl_cipher_iv_length($this->cipher));

        $value = \openssl_encrypt(
            $value, $this->cipher, $this->key, 0, $iv
        );

        if ($value === false) {
            throw new \Exception('Could not encrypt the data.');
        }

        $mac = $this->hash($iv = base64_encode($iv), $value);

        $json = json_encode(compact('iv', 'value', 'mac'));

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Could not encrypt the data.');
        }

        return base64_encode($json);
    }

    private function hash($iv, $value) {
        return hash_hmac('sha256', $iv.$value, $this->key);
    }

    public function decrypt($payload) {
        $payload = $this->getJsonPayload($payload);

        $iv = base64_decode($payload['iv']);

        $decrypted = \openssl_decrypt(
            $payload['value'], $this->cipher, $this->key, 0, $iv
        );

        if ($decrypted === false) {
            throw new \Exception('Could not decrypt the data.');
        }

        return $decrypted;
    }

    private function getJsonPayload($payload) {
        $payload = json_decode(base64_decode($payload), true);

        if (! $this->validPayload($payload)) {
            throw new \Exception('The payload is invalid.');
        }

        if (! $this->validMac($payload)) {
            throw new \Exception('The MAC is invalid.');
        }

        return $payload;
    }

    private function validPayload($payload) {
        return is_array($payload) && isset($payload['iv'], $payload['value'], $payload['mac']) &&
               strlen(base64_decode($payload['iv'], true)) === openssl_cipher_iv_length($this->cipher);
    }

    private function validMac(array $payload) {
        $calculated = $this->calculateMac($payload, $bytes = random_bytes(16));

        return hash_equals(
            hash_hmac('sha256', $payload['mac'], $bytes, true), $calculated
        );
    }

    private function calculateMac($payload, $bytes) {
        return hash_hmac(
            'sha256', $this->hash($payload['iv'], $payload['value']), $bytes, true
        );
    }

}
