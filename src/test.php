<?php

require_once __DIR__.'/../vendor/autoload.php';

$key = 'dc2ee8ffcda0727e532b5159ba2a0909';

$text = json_encode([
    'method' => 'webservice',
    'params' => [
        'a' => 'foo',
        'b' => 'bar',
    ],
], JSON_UNESCAPED_UNICODE);

$encrypt = encrypt($text, $key);

$decrypt = decrypt($encrypt, $key);

var_dump($encrypt, $decrypt);

var_dump(json_decode($decrypt, true));
