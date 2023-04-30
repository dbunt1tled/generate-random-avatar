<?php

namespace DBUnt1tled\RandomAvatar\lib\shapes\property;

use DBUnt1tled\RandomAvatar\lib\colors\RAColor;
use DBUnt1tled\RandomAvatar\lib\colors\RAColorInterface;

class RABorder implements BorderInterface
{
    /** @var RAColorInterface */
    private $color;
    /** @var int */
    private $width;

    /**
     * RABorder constructor.
     */
    public function __construct(int $width = null, string $color = null)
    {
        $this->color = new RAColor($color);
        $this->setWidth($width);
    }

    /**
     * @return RAColorInterface|RAColor|string
     */
    public function getColor(bool $asString = true)
    {
        if ($asString) {
            return (string) $this->color;
        }

        return $this->color;
    }

    public function setColor(?string $color): BorderInterface
    {
        if (null === $color) {
            $this->color->setRandomColor();
        } else {
            $this->color->setColor($color);
        }

        return $this;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(?int $width): BorderInterface
    {
        $this->width = is_numeric($width) ? (int) abs($width) : 0;

        return $this;
    }

    public function hasBorder(): bool
    {
        return $this->getWidth() >= 1;
    }
}
