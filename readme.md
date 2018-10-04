# 对称加密、解密函数

## 安装
```
composer require mradang/encryption
```

## 使用
```php
// 加密，默认使用 AES-256-CBC 加密，$key 长度为32
$encrypter = new \mradang\Encryption\Encrypter($key);
$encrypt = $encrypter->encrypt($text);

// 解密
$encrypter = new \mradang\Encryption\Encrypter($key);
$decrypt = $encrypter->decrypt($encrypt);
```