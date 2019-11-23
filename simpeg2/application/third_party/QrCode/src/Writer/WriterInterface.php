<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\QrCode\Writer;

use Endroid\QrCode\QrCodeInterface;

interface WriterInterface
{
    /*public function writeString(QrCodeInterface $qrCode): string;

    public function writeDataUri(QrCodeInterface $qrCode): string;

    public function writeFile(QrCodeInterface $qrCode, string $path): void;

    public static function getContentType(): string;

    public static function supportsExtension(string $extension): bool;

    public static function getSupportedExtensions(): array;

    public function getName(): string;*/

    public function writeString(QrCodeInterface $qrCode);

    public function writeDataUri(QrCodeInterface $qrCode);

    public function writeFile(QrCodeInterface $qrCode, $path);

    public static function getContentType();

    public static function supportsExtension($extension);

    public static function getSupportedExtensions();

    public function getName();
}
