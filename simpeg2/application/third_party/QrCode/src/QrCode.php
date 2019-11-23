<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\QrCode;

use Endroid\QrCode\Exception\InvalidPathException;
use Endroid\QrCode\Exception\UnsupportedExtensionException;
use Endroid\QrCode\Writer\WriterInterface;

class QrCode implements QrCodeInterface
{
    const LABEL_FONT_PATH_DEFAULT = '/../assets/fonts/noto_sans.otf';

    private $text;

    private $size = 300;
    private $margin = 10;

    private $foregroundColor = [
        'r' => 0,
        'g' => 0,
        'b' => 0,
    ];

    private $backgroundColor = [
        'r' => 255,
        'g' => 255,
        'b' => 255,
    ];

    private $encoding = 'UTF-8';
    private $errorCorrectionLevel;

    private $logoPath;
    private $logoWidth;

    private $label;
    private $labelFontSize = 16;
    private $labelFontPath = self::LABEL_FONT_PATH_DEFAULT;
    private $labelAlignment;
    private $labelMargin = [
        't' => 0,
        'r' => 10,
        'b' => 10,
        'l' => 10,
    ];

    private $writerRegistry;
    private $writer;
    private $validateResult = false;

    //public function __construct(string $text = '')
    public function __construct($text = '')
    {
        $this->text = $text;

        $this->errorCorrectionLevel = new ErrorCorrectionLevel(ErrorCorrectionLevel::LOW);
        $this->labelAlignment = new LabelAlignment(LabelAlignment::CENTER);
    }

    //public function setText(string $text): void
    public function setText($text)
    {
        $this->text = $text;
    }

    //public function getText(): string
    public function getText()
    {
        return $this->text;
    }

    //public function setSize(int $size): void
    public function setSize($size)
    {
        $this->size = $size;
    }

    //public function getSize(): int
    public function getSize()
    {
        return $this->size;
    }

    //public function setMargin(int $margin): void
    public function setMargin($margin)
    {
        $this->margin = $margin;
    }

    //public function getMargin(): int
    public function getMargin()
    {
        return $this->margin;
    }

    //public function setForegroundColor(array $foregroundColor): void
    public function setForegroundColor(array $foregroundColor)
    {
        $this->foregroundColor = $foregroundColor;
    }

    //public function getForegroundColor(): array
    public function getForegroundColor()
    {
        return $this->foregroundColor;
    }

    //public function setBackgroundColor(array $backgroundColor): void
    public function setBackgroundColor(array $backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;
    }

    //public function getBackgroundColor(): array
    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    //public function setEncoding(string $encoding): void
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
    }

    //public function getEncoding(): string
    public function getEncoding()
    {
        return $this->encoding;
    }

    //public function setErrorCorrectionLevel(string $errorCorrectionLevel): void
    public function setErrorCorrectionLevel($errorCorrectionLevel)
    {
        $this->errorCorrectionLevel = new ErrorCorrectionLevel($errorCorrectionLevel);
    }

    //public function getErrorCorrectionLevel(): string
    public function getErrorCorrectionLevel()
    {
        return $this->errorCorrectionLevel->getValue();
    }

    //public function setLogoPath(string $logoPath): void
    public function setLogoPath($logoPath)
    {
        $logoPath = realpath($logoPath);

        if (!is_file($logoPath)) {
            throw new InvalidPathException('Invalid logo path: '.$logoPath);
        }

        $this->logoPath = $logoPath;
    }

    //public function getLogoPath(): ?string
    public function getLogoPath()
    {
        return $this->logoPath;
    }

    //public function setLogoWidth(int $logoWidth): void
    public function setLogoWidth($logoWidth)
    {
        $this->logoWidth = $logoWidth;
    }

    //public function getLogoWidth(): ?int
    public function getLogoWidth()
    {
        return $this->logoWidth;
    }

    //public function setLabel(string $label, int $labelFontSize = null, string $labelFontPath = null, string $labelAlignment = null, array $labelMargin = null): void
    public function setLabel($label, $labelFontSize = null, $labelFontPath = null, $labelAlignment = null, array $labelMargin = null)
    {
        $this->label = $label;

        if (null !== $labelFontSize) {
            $this->setLabelFontSize($labelFontSize);
        }

        if (null !== $labelFontPath) {
            $this->setLabelFontPath($labelFontPath);
        }

        if (null !== $labelAlignment) {
            $this->setLabelAlignment($labelAlignment);
        }

        if (null !== $labelMargin) {
            $this->setLabelMargin($labelMargin);
        }
    }

    //public function getLabel(): ?string
    public function getLabel()
    {
        return $this->label;
    }

    //public function setLabelFontSize(int $labelFontSize): void
    public function setLabelFontSize($labelFontSize)
    {
        $this->labelFontSize = $labelFontSize;
    }

    //public function getLabelFontSize(): ?int
    public function getLabelFontSize()
    {
        return $this->labelFontSize;
    }

    //public function setLabelFontPath(string $labelFontPath): void
    public function setLabelFontPath($labelFontPath)
    {
        $labelFontPath = realpath($labelFontPath);
        if (!is_file($labelFontPath)) {
            throw new InvalidPathException('Invalid label font path: '.$labelFontPath);
        }

        $this->labelFontPath = $labelFontPath;
    }

    //public function getLabelFontPath(): ?string
    public function getLabelFontPath()
    {
        return $this->labelFontPath;
    }

    //public function setLabelAlignment(string $labelAlignment): void
    public function setLabelAlignment($labelAlignment)
    {
        $this->labelAlignment = new LabelAlignment($labelAlignment);
    }

    //public function getLabelAlignment(): ?string
    public function getLabelAlignment()
    {
        return $this->labelAlignment->getValue();
    }

    //public function setLabelMargin(array $labelMargin): void
    public function setLabelMargin(array $labelMargin)
    {
        $this->labelMargin = array_merge($this->labelMargin, $labelMargin);
    }

    //public function getLabelMargin(): ?array
    public function getLabelMargin()
    {
        return $this->labelMargin;
    }

    //public function setWriterRegistry(WriterRegistryInterface $writerRegistry): void
    public function setWriterRegistry(WriterRegistryInterface $writerRegistry)
    {
        $this->writerRegistry = $writerRegistry;
    }

    //public function setWriter(WriterInterface $writer): void
    public function setWriter(WriterInterface $writer)
    {
        $this->writer = $writer;
    }

    //public function getWriter(string $name = null): WriterInterface
    public function getWriter($name = null)
    {
        if (!$this->writerRegistry instanceof WriterRegistryInterface) {
            $this->createWriterRegistry();
        }

        if (!is_null($name)) {
            return $this->writerRegistry->getWriter($name);
        }

        if ($this->writer instanceof WriterInterface) {
            return $this->writer;
        }

        return $this->writerRegistry->getDefaultWriter();
    }

    private function createWriterRegistry()
    {
        $this->writerRegistry = new WriterRegistry();
        $this->writerRegistry->loadDefaultWriters();
    }

    //public function setWriterByName(string $name)
    public function setWriterByName($name)
    {
        $this->writer = $this->getWriter($name);
    }

    //public function setWriterByPath(string $path): void
    public function setWriterByPath($path)
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        $this->setWriterByExtension($extension);
    }

    //public function setWriterByExtension(string $extension): void
    public function setWriterByExtension($extension)
    {
        foreach ($this->writerRegistry->getWriters() as $writer) {
            if ($writer->supportsExtension($extension)) {
                $this->writer = $writer;

                return;
            }
        }

        throw new UnsupportedExtensionException('Missing writer for extension "'.$extension.'"');
    }

    //public function writeString(): string
    public function writeString()
    {
        return $this->getWriter()->writeString($this);
    }

    //public function writeDataUri(): string
    public function writeDataUri()
    {
        return $this->getWriter()->writeDataUri($this);
    }

    //public function writeFile(string $path): void
    public function writeFile($path)
    {
        $this->getWriter()->writeFile($this, $path);
    }

    //public function getContentType(): string
    public function getContentType()
    {
        return $this->getWriter()->getContentType();
    }

    //public function setValidateResult(bool $validateResult): void
    public function setValidateResult($validateResult)
    {
        $this->validateResult = $validateResult;
    }

    //public function getValidateResult(): bool
    public function getValidateResult()
    {
        return $this->validateResult;
    }
}
