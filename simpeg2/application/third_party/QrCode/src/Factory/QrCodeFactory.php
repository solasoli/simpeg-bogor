<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\QrCode\Factory;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\QrCodeInterface;
use Endroid\QrCode\WriterRegistryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyAccess;

class QrCodeFactory implements QrCodeFactoryInterface
{
    private $writerRegistry;
    private $optionsResolver;
    private $defaultOptions;
    private $definedOptions = [
        'writer',
        'size',
        'margin',
        'foreground_color',
        'background_color',
        'encoding',
        'error_correction_level',
        'logo_path',
        'logo_width',
        'label',
        'label_font_size',
        'label_font_path',
        'label_alignment',
        'label_margin',
        'validate_result',
    ];

    public function __construct(array $defaultOptions = [], WriterRegistryInterface $writerRegistry = null)
    {
        $this->defaultOptions = $defaultOptions;
        $this->writerRegistry = $writerRegistry;
    }

    //public function create(string $text = '', array $options = []): QrCodeInterface
    public function create($text = '', array $options = [])
    {
        $options = $this->getOptionsResolver()->resolve($options);
        $accessor = PropertyAccess::createPropertyAccessor();

        $qrCode = new QrCode($text);

        if ($this->writerRegistry instanceof WriterRegistryInterface) {
            $qrCode->setWriterRegistry($this->writerRegistry);
        }

        foreach ($this->definedOptions as $option) {
            if (isset($options[$option])) {
                if ('writer' === $option) {
                    $options['writer_by_name'] = $options[$option];
                    $option = 'writer_by_name';
                }
                $accessor->setValue($qrCode, $option, $options[$option]);
            }
        }

        return $qrCode;
    }

    //private function getOptionsResolver(): OptionsResolver
    private function getOptionsResolver()
    {
        if (!$this->optionsResolver instanceof OptionsResolver) {
            $this->optionsResolver = $this->createOptionsResolver();
        }

        return $this->optionsResolver;
    }

    //private function createOptionsResolver(): OptionsResolver
    private function createOptionsResolver()
    {
        $optionsResolver = new OptionsResolver();
        $optionsResolver
            ->setDefaults($this->defaultOptions)
            ->setDefined($this->definedOptions)
        ;

        return $optionsResolver;
    }
}
