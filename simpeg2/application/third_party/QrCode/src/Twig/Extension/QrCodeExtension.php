<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\QrCode\Twig\Extension;

use Endroid\QrCode\Factory\QrCodeFactoryInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig_Extension;
use Twig_SimpleFunction;

class QrCodeExtension extends Twig_Extension
{
    private $qrCodeFactory;
    private $router;

    public function __construct(QrCodeFactoryInterface $qrCodeFactory, RouterInterface $router)
    {
        $this->qrCodeFactory = $qrCodeFactory;
        $this->router = $router;
    }

    //public function getFunctions(): array
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('qrcode_path', [$this, 'qrCodePathFunction']),
            new Twig_SimpleFunction('qrcode_url', [$this, 'qrCodeUrlFunction']),
            new Twig_SimpleFunction('qrcode_data_uri', [$this, 'qrCodeDataUriFunction']),
        ];
    }

    //public function qrcodeUrlFunction(string $text, array $options = []): string
    public function qrcodeUrlFunction($text, array $options = [])
    {
        return $this->getQrCodeReference($text, $options, UrlGeneratorInterface::ABSOLUTE_URL);
    }

    //public function qrCodePathFunction(string $text, array $options = []): string
    public function qrCodePathFunction($text, array $options = [])
    {
        return $this->getQrCodeReference($text, $options, UrlGeneratorInterface::ABSOLUTE_PATH);
    }

    //public function getQrCodeReference(string $text, array $options = [], int $referenceType): string
    public function getQrCodeReference($text, array $options = [], $referenceType)
    {
        $qrCode = $this->qrCodeFactory->create($text, $options);
        $supportedExtensions = $qrCode->getWriter()->getSupportedExtensions();

        $options['text'] = $text;
        $options['extension'] = current($supportedExtensions);

        return $this->router->generate('endroid_qrcode_generate', $options, $referenceType);
    }

    //public function qrcodeDataUriFunction(string $text, array $options = []): string
    public function qrcodeDataUriFunction($text, array $options = [])
    {
        $qrCode = $this->qrCodeFactory->create($text, $options);

        return $qrCode->writeDataUri();
    }
}
