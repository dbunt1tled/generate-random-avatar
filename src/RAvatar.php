<?php

namespace DBUnt1tled\RandomAvatar;

use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use DBUnt1tled\RandomAvatar\lib\fonts\RAFont;
use DBUnt1tled\RandomAvatar\lib\fonts\RAFontInterface;
use DBUnt1tled\RandomAvatar\lib\shapes\RAShapeFactory;
use DBUnt1tled\RandomAvatar\lib\shapes\ShapeInterface;
use DBUnt1tled\RandomAvatar\lib\drivers\RADriverFactory;
use DBUnt1tled\RandomAvatar\lib\drivers\RADriverInterface;

class RAvatar
{
    /** @var RADriverInterface */
    protected $driver;
    /** @var ImageManager */
    private $imageManager;
    /** @var ShapeInterface */
    private $figure;
    /** @var RAFontInterface */
    private $font;
    /** @var RAShapeFactory */
    private $shapeFactory;
    /** @var RADriverFactory */
    private $driverFactory;

    /**
     * RAvatar constructor.
     */
    public function __construct(ShapeInterface $figure = null, RAFontInterface $font = null, RADriverInterface $driver = null)
    {
        $this->shapeFactory = new RAShapeFactory();
        $this->driverFactory = new RADriverFactory();

        $this->driver = $driver ?? $this->driverFactory->getFirstAvailableDriverObj();
        $this->initImageManager();

        $this->figure = $figure ?? $this->shapeFactory->getShapeObject($this->shapeFactory->getShapesAvailable()[0]);
        $this->font = $font ?? new RAFont();
    }

    public function toJpeg(int $quality = 100): Image
    {
        return $this->generateCanvas()->encode('jpeg', $quality);
    }

    public function toPng(): Image
    {
        return $this->generateCanvas()->encode('png');
    }

    public function __toString(): string
    {
        return (string) $this->generateCanvas()->encode('data-url');
    }

    public function saveFile(string $name, int $quality = 100): Image
    {
        return $this->generateCanvas()->save($name, $quality);
    }

    public function getDriver(): RADriverInterface
    {
        return $this->driver;
    }

    public function setDriverGD(): self
    {
        $this->setDriverFromName(RADriverFactory::DRIVER_GD);

        return $this;
    }

    public function setDriverImageMagick(): self
    {
        $this->setDriverFromName(RADriverFactory::DRIVER_IMAGE_MAGICK);

        return $this;
    }

    public function setDriver(RADriverInterface $driver): self
    {
        if (null !== $driver) {
            $this->driver = $driver;
            $this->initImageManager();

            return $this;
        }

        throw new \RuntimeException($driver->getName().' not available.');
    }

    public function setDriverFromName(?string $driver): self
    {
        if (null !== $driver && !in_array($driver, $this->driverFactory->getAvailableDrivers(), false)) {
            throw new \RuntimeException($driver.' not available.');
        }
        if (null === $driver) {
            $this->driver = $this->driverFactory->getFirstAvailableDriverObj();
        } else {
            $this->driver = $this->driverFactory->getDriverObject($driver);
        }
        $this->initImageManager();

        return $this;
    }

    public function getFigure(): ShapeInterface
    {
        return $this->figure;
    }

    public function setFigure(ShapeInterface $figure): self
    {
        $this->figure = $figure;

        return $this;
    }

    public function getFont(): RAFontInterface
    {
        return $this->font;
    }

    public function setFont(RAFontInterface $font): self
    {
        $this->font = $font;

        return $this;
    }

    public function getAvailableShapes(): array
    {
        return $this->shapeFactory->getShapesAvailable();
    }

    public function setInitials(int $maxLetters = 2): self
    {
        $this->font->setInitials($maxLetters);

        return $this;
    }

    public function setBorder(int $width = 0, string $color = null): self
    {
        $this->figure->setBorder($width, $color);

        return $this;
    }

    public function setShape(string $shape = 'rectangle', int $width = 80, int $height = 80, string $bgColor = null): self
    {
        $this->figure = $this->shapeFactory->getShapeObject($shape)
            ->setBackground($bgColor)
            ->setWidth($width)
            ->setHeight($height);

        return $this;
    }

    public function setText(string $text = '', string $color = null, int $size = 22, int $angle = 0): self
    {
        $this->font
            ->setText($text)
            ->setSize($size)
            ->setColor($color)
            ->setAngle($angle);

        return $this;
    }

    public function setInverseColorText(): self
    {
        $this->getFont()->getColor(false)->setColorFromBackground($this->getFigure()->getBackground());

        return $this;
    }

    public function setTextColor(string $color = null): self
    {
        $this->getFont()->getColor(false)->setColor($color);

        return $this;
    }

    public function setBackGroundColor(string $color = null): self
    {
        $this->getFigure()->getBackground(false)->setColor($color);

        return $this;
    }

    private function initImageManager(): self
    {
        $this->imageManager = new ImageManager(['driver' => $this->getDriver()->getName()]);

        return $this;
    }

    private function generateCanvas(): Image
    {
        $image = $this->imageManager->canvas($this->figure->getWidth(), $this->figure->getHeight());
        $this->figure->applyImage($image);
        if (!empty($this->font->getText())) {
            $this->figure->applyImageText($image, $this->font);
        }

        return $image;
    }
}
