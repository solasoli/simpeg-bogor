<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\QrCode\Writer;

use Endroid\QrCode\QrCodeInterface;

abstract class AbstractWriter implements WriterInterface
{
    //public function writeDataUri(QrCodeInterface $qrCode): string
    public function writeDataUri(QrCodeInterface $qrCode)
    {
        $dataUri = 'data:'.$this->getContentType().';base64,'.base64_encode($this->writeString($qrCode));

        return $dataUri;
    }

    //public function writeFile(QrCodeInterface $qrCode, string $path): void
    public function writeFile(QrCodeInterface $qrCode, $path)
    {
        $string = $this->writeString($qrCode);
        error_reporting(0);
        file_put_contents($path, $string);
        error_reporting(1);
    }

    //public static function supportsExtension(string $extension): bool
    public static function supportsExtension($extension)
    {
        return in_array($extension, static::getSupportedExtensions());
    }

    public static function getSupportedExtensions()
    {
        return [];
    }

    //abstract public function getName(): string;
    abstract public function getName();
}
