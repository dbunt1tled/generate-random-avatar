<?php

namespace DBUnt1tled\RandomAvatar\lib\shapes\classes;

use Intervention\Image\Image;
use Intervention\Image\AbstractFont;
use Intervention\Image\AbstractShape;
use DBUnt1tled\RandomAvatar\lib\colors\RAColor;
use DBUnt1tled\RandomAvatar\lib\fonts\RAFontInterface;
use DBUnt1tled\RandomAvatar\lib\shapes\ShapeInterface;
use DBUnt1tled\RandomAvatar\lib\colors\RAColorInterface;
use DBUnt1tled\RandomAvatar\lib\shapes\property\RABorder;
use DBUnt1tled\RandomAvatar\lib\shapes\property\BorderInterface;

class RAEllipse implements ShapeInterface
{
    public const SHAPE_NAME = 'ellipse';

    /** @var RAColorInterface */
    private $background;
    /** @var BorderInterface */
    private $border;
    /** @var int */
    private $width = 80;
    /** @var int */
    private $height = 80;

    /**
     * RAEllipse constructor.
     */
    public function __construct(int $width = 80, int $height = 80, string $bgColor = null)
    {
        $this->background = new RAColor($bgColor);
        $this->setWidth($width);
        $this->setHeight($height);
        $this->border = new RABorder();
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): ShapeInterface
    {
        $this->width = is_numeric($width) ? abs((int) $width) : $this->width;

        return $this;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): ShapeInterface
    {
        $this->height = is_numeric($height) ? abs((int) $height) : $this->height;

        return $this;
    }

    public function setBackground(string $bgColor = null): ShapeInterface
    {
        $this->background->setColor($bgColor);

        return $this;
    }

    public function setBorder(int $width, string $color = null): ShapeInterface
    {
        $this->border->setWidth($width);
        $this->border->setColor($color);

        return $this;
    }

    public function getBorder(): BorderInterface
    {
        return $this->border;
    }

    /**
     * @return RAColorInterface|RAColor|string
     */
    public function getBackground(bool $asString = true)
    {
        if ($asString) {
            return (string) $this->background;
        }

        return $this->background;
    }

    public function hasBorder(): bool
    {
        return $this->border->hasBorder();
    }

    public function isRound(): bool
    {
        return true;
    }

    public function applyImageText(Image $image, RAFontInterface $font): void
    {
        $image->text($font->getText(), $this->getWidth() / 2, $this->getHeight() / 2, function ($text) use ($font) {
            /* @var AbstractFont $text */
            if ($font->isFontAvailable()) {
                $text->file($font->getFontFile());
            }
            $text->size($font->getSize());
            $text->color($font->getColor());
            $text->angle($font->getAngle());
            $text->align('center');
            $text->valign('center');
        });
    }

    public function getName(): string
    {
        return static::SHAPE_NAME;
    }

    public function applyImage(Image $image): void
    {
        $image->ellipse(
            $this->getWidth() - ($this->getBorder()->getWidth() / 2) - 2,
            $this->getHeight() - ($this->getBorder()->getWidth() / 2) - 2,
            $this->getWidth() / 2,
            $this->getHeight() / 2,
            function ($draw) {
                /* @var AbstractShape $draw */
                $draw->background($this->getBackground());
                if ($this->hasBorder()) {
                    $draw->border($this->getBorder()->getWidth(), $this->getBorder()->getColor());
                }

                return $draw;
            }
        );
    }
}
