<?php

namespace QrCodeReader\Lib;

require_once('qrcode/QRCodeReader.php');

interface Reader {

    public function decode($image);


    public  function reset();


}