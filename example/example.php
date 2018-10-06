<?php

require_once __DIR__.'/../vendor/autoload.php';

$key = md5(time());

$text = json_encode([
    'method' => 'webservice',
    'params' => [
        'a' => 'foo',
        'b' => 'bar',
    ],
], JSON_UNESCAPED_UNICODE);

$encrypter = new \mradang\Encryption\Encrypter($key);

$encrypt = $encrypter->encrypt($text);
$decrypt = $encrypter->decrypt($encrypt);

var_dump($encrypt, $decrypt);

var_dump(json_decode($decrypt, true));
