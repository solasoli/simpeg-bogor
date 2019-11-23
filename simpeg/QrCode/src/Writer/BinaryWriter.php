<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\QrCode\Writer;

use Endroid\QrCode\QrCodeInterface;

class BinaryWriter extends AbstractWriter
{
    //public function writeString(QrCodeInterface $qrCode): string
    public function writeString(QrCodeInterface $qrCode)
    {
        $string = '
            0001010101
            0001010101
            1000101010
            0001010101
            0101010101
            0001010101
            0001010101
            0001010101
            0001010101
            1000101010
        ';

        return $string;
    }

    //public static function getContentType(): string
    public static function getContentType()
    {
        return 'text/plain';
    }

    //public static function getSupportedExtensions(): array
    public static function getSupportedExtensions()
    {
        return ['bin', 'txt'];
    }

    //public function getName(): string
    public function getName()
    {
        return 'binary';
    }
}
