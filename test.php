<?php
/**
 * Author mapo
 * Date   2021/12/9
 */

require __DIR__ . '/vendor/autoload.php';

use QrCodeReader\Lib\QrReader;

$qrcode = new QrReader(__DIR__ . '/src/qr.png');  //图片路径
$text = $qrcode->decode(); //返回识别后的文本
echo $text;