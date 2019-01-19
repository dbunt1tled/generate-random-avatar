<?php

namespace DBUnt1tled\RandomAvatar;

use DBUnt1tled\RandomAvatar\lib\drivers\RADriverFactory;
use DBUnt1tled\RandomAvatar\lib\drivers\RADriverInterface;
use DBUnt1tled\RandomAvatar\lib\fonts\RAFont;
use DBUnt1tled\RandomAvatar\lib\fonts\RAFontInterface;
use DBUnt1tled\RandomAvatar\lib\shapes\RAShapeFactory;
use DBUnt1tled\RandomAvatar\lib\shapes\ShapeInterface;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

class RAvatar
{
    /** @var ImageManager */
    private $imageManager;
    /** @var RADriverInterface */
    protected $driver;
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
     * @param ShapeInterface|null $figure
     * @param RAFontInterface|null $font
     * @param RADriverInterface|null $driver
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

    /**
     * @param int $quality
     * @return Image
     */
    public function toJpeg(int $quality = 100) : Image
    {
        return $this->generateCanvas()->encode('jpeg', $quality);
    }

    /**
     * @return Image
     */
    public function toPng() : Image
    {
        return $this->generateCanvas()->encode('png');
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->generateCanvas()->encode('data-url');
    }

    /**
     * @param string $name
     * @param int $quality
     * @return Image
     */
    public function saveFile(string $name, int $quality = 100) : Image
    {
        return $this->generateCanvas()->save($name, $quality);
    }
    /**
     * @return RADriverInterface
     */
    public function getDriver(): RADriverInterface
    {
        return $this->driver;
    }

    public function setDriverGD(): RAvatar
    {
        $this->setDriverFromName(RADriverFactory::DRIVER_GD);
        return $this;
    }

    public function setDriverImageMagick(): RAvatar
    {
        $this->setDriverFromName(RADriverFactory::DRIVER_IMAGE_MAGICK);
        return $this;
    }

    public function setDriver(RADriverInterface $driver): RAvatar
    {
        if ($driver !== null) {
            $this->driver = $driver;
            $this->initImageManager();
            return $this;
        }
        throw new \RuntimeException($driver->getName() . ' not available.');
    }
    /**
     * @param string|null $driver
     * @return RAvatar
     */
    public function setDriverFromName(?string $driver): RAvatar
    {
        if ($driver !== null && !in_array($driver, $this->driverFactory->getAvailableDrivers(), false)) {
            throw new \RuntimeException($driver . ' not available.');
        }
        if ($driver === null) {
            $this->driver = $this->driverFactory->getFirstAvailableDriverObj();
        } else {
            $this->driver = $this->driverFactory->getDriverObject($driver);
        }
        $this->initImageManager();
        return $this;
    }
    /**
     * @return ShapeInterface
     */
    public function getFigure(): ShapeInterface
    {
        return $this->figure;
    }

    /**
     * @param ShapeInterface $figure
     * @return RAvatar
     */
    public function setFigure(ShapeInterface $figure): RAvatar
    {
        $this->figure = $figure;
        return $this;
    }

    /**
     * @return RAFontInterface
     */
    public function getFont(): RAFontInterface
    {
        return $this->font;
    }

    /**
     * @param RAFontInterface $font
     * @return RAvatar
     */
    public function setFont(RAFontInterface $font): RAvatar
    {
        $this->font = $font;
        return $this;
    }

    /**
     * @return array
     */
    public function getAvailableShapes(): array
    {
        return $this->shapeFactory->getShapesAvailable();
    }

    /**
     * @param int $maxLetters
     * @return RAvatar
     */
    public function setInitials(int $maxLetters = 2): RAvatar
    {
        $this->font->setInitials($maxLetters);
        return $this;
    }

    /**
     * @param int $width
     * @param string|null $color
     * @return RAvatar
     */
    public function setBorder(int $width = 0, string $color =  null): RAvatar
    {
        $this->figure->setBorder($width, $color);
        return $this;
    }

    /**
     * @param string $shape
     * @param int $width
     * @param int $height
     * @param string|null $bgColor
     * @return RAvatar
     */
    public function setShape(string $shape = 'rectangle', int $width = 80, int $height = 80, string $bgColor = null): RAvatar
    {
        $this->figure = $this->shapeFactory->getShapeObject($shape)
            ->setBackground($bgColor)
            ->setWidth($width)
            ->setHeight($height);

        return $this;
    }

    /**
     * @param string $text
     * @param string|null $color
     * @param int $size
     * @param int $angle
     * @return RAvatar
     */
    public function setText(string $text = '', string $color = null, int $size = 22, int $angle = 0): RAvatar
    {
        $this->font
            ->setText($text)
            ->setSize($size)
            ->setColor($color)
            ->setAngle($angle);
        return $this;
    }

    /**
     * @return RAvatar
     */
    public function setInverseColorText(): RAvatar
    {
        $this->getFont()->getColor(false)->setColorFromBackground($this->getFigure()->getBackground());
        return $this;
    }

    /**
     * @param string|null $color
     * @return RAvatar
     */
    public function setTextColor(?string $color = null): RAvatar
    {
        $this->getFont()->getColor(false)->setColor($color);
        return $this;
    }

    /**
     * @param string|null $color
     * @return RAvatar
     */
    public function setBackGroundColor(?string $color = null): RAvatar
    {
        $this->getFigure()->getBackground(false)->setColor($color);
        return $this;
    }
    /**
     * @return RAvatar
     */
    private function initImageManager(): RAvatar
    {
        $this->imageManager = new ImageManager(['driver' => $this->getDriver()->getName()]);
        return $this;
    }

    /**
     * @return Image
     */
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
