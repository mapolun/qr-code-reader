# qr-code-reader
php识别二维码内容, 不需要安装扩展


## 安装
$ composer require mapolun/qr-code-reader

## 要求
* PHP >= 5.3 && PHP <= 8.0

## 示例 

```php
  require __DIR__ . '/vendor/autoload.php';

  use QrCodeReader\Lib\QrReader;

  $qrcode = new QrReader(__DIR__ . '/src/qr.png');  //图片路径
  $text = $qrcode->decode(); //返回识别后的文本
  echo $text;
```
