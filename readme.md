# 对称加密、解密函数
添加全局函数 encrypt、decrypt，实现字符串的加密与解密

## 安装
```
composer require mradang/encryption
```

## 使用
```php
// 加密
$encrypt = encrypt($text, $key);

// 解密
$decrypt = decrypt($encrypt, $key);
```