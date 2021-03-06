<?php

namespace QrCodeReader\Lib;

require_once(__DIR__ . '/Common/customFunctions.php');

final class QrReader
{
    const SOURCE_TYPE_FILE     = 'file';
    const SOURCE_TYPE_BLOB     = 'blob';
    const SOURCE_TYPE_RESOURCE = 'resource';

    public $result;

    function __construct($imgsource, $sourcetype = QrReader::SOURCE_TYPE_FILE, $isUseImagickIfAvailable = true)
    {

        try {
            switch ($sourcetype) {
                case QrReader::SOURCE_TYPE_FILE:
                    if ($isUseImagickIfAvailable && extension_loaded('imagick')) {
                        $im = new \Imagick();
                        $im->readImage($imgsource);
                    } else {
                        $image = file_get_contents($imgsource);
                        $im = imagecreatefromstring($image);
                    }

                    break;

                case QrReader::SOURCE_TYPE_BLOB:
                    if ($isUseImagickIfAvailable && extension_loaded('imagick')) {
                        $im = new \Imagick();
                        $im->readimageblob($imgsource);
                    } else {
                        $im = imagecreatefromstring($imgsource);
                    }

                    break;

                case QrReader::SOURCE_TYPE_RESOURCE:
                    $im = $imgsource;
                    if ($isUseImagickIfAvailable && extension_loaded('imagick')) {
                        $isUseImagickIfAvailable = true;
                    } else {
                        $isUseImagickIfAvailable = false;
                    }

                    break;
            }

            if ($isUseImagickIfAvailable && extension_loaded('imagick')) {
                $width = $im->getImageWidth();
                $height = $im->getImageHeight();
                $source = new \QrCodeReader\Lib\IMagickLuminanceSource($im, $width, $height);
            } else {
                $width = imagesx($im);
                $height = imagesy($im);
                $source = new \QrCodeReader\Lib\GDLuminanceSource($im, $width, $height);
            }
            $histo = new \QrCodeReader\Lib\Common\HybridBinarizer($source);
            $bitmap = new \QrCodeReader\Lib\BinaryBitmap($histo);
            $reader = new \QrCodeReader\Lib\Qrcode\QRCodeReader();

            $this->result = $reader->decode($bitmap);
        } catch (\QrCodeReader\Lib\NotFoundException $er) {
            $this->result = false;
        } catch (\QrCodeReader\Lib\FormatException $er) {
            $this->result = false;
        } catch (\QrCodeReader\Lib\ChecksumException $er) {
            $this->result = false;
        }
    }

    public function text()
    {
        if (method_exists($this->result, 'toString')) {
            return ($this->result->toString());
        } else {
            return $this->result;
        }
    }

    public function decode()
    {
        return $this->text();
    }
}

