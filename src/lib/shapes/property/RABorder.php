<?php

namespace DBUnt1tled\RandomAvatar\lib\shapes\property;

use DBUnt1tled\RandomAvatar\lib\colors\RAColorInterface;
use DBUnt1tled\RandomAvatar\lib\colors\RAColor;

class RABorder implements BorderInterface
{
    /** @var RAColorInterface $color */
    private $color;
    /** @var int $width */
    private $width;

    /**
     * RABorder constructor.
     * @param int|null $width
     * @param string|null $color
     */
    public function __construct(int $width = null, string $color = null)
    {
        $this->color = new RAColor($color);
        $this->setWidth($width);
    }

    /**
     * @param bool $asString
     * @return RAColorInterface|RAColor|string
     */
    public function getColor(bool $asString = true)
    {
        if ($asString) {
            return (string)$this->color;
        }
        return $this->color;
    }

    /**
     * @param string|null $color
     * @return BorderInterface
     */
    public function setColor(?string $color): BorderInterface
    {
        if ($color === null) {
            $this->color->setRandomColor();
        } else {
            $this->color->setColor($color);
        }
        return $this;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @param int|null $width
     * @return BorderInterface
     */
    public function setWidth(?int $width): BorderInterface
    {
        $this->width = is_numeric($width) ? (int)abs($width) : 0;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasBorder(): bool
    {
        return ($this->getWidth() >= 1);
    }
}
