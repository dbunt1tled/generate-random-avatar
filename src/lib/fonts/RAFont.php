<?php

namespace DBUnt1tled\RandomAvatar\lib\fonts;

use DBUnt1tled\RandomAvatar\lib\colors\RAColor;
use DBUnt1tled\RandomAvatar\lib\fonts\property\RAText;
use DBUnt1tled\RandomAvatar\lib\colors\RAColorInterface;
use DBUnt1tled\RandomAvatar\lib\fonts\property\TextInterface;

class RAFont implements RAFontInterface
{
    /** @var TextInterface */
    private $text;
    /** @var int */
    private $size;
    /** @var RAColorInterface */
    private $color;
    /** @var int */
    private $angle;
    /** @var string */
    private $fontFile;

    /**
     * RAFont constructor.
     */
    public function __construct(
        string $text = null,
        string $color = null,
        int $size = 70,
        int $angle = 0
    ) {
        $this->text = new RAText($text);
        $this->color = new RAColor($color);
        $this->size = $size;
        $this->angle = $angle;
        $this->fontFile = realpath(__DIR__).'/../../fonts/Roboto-Regular.ttf';
    }

    public function getText(): string
    {
        return (string) $this->text;
    }

    public function setText(string $text): RAFontInterface
    {
        $this->text->setText($text);

        return $this;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(int $size): RAFontInterface
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return RAColor|RAColorInterface|string
     */
    public function getColor(bool $asString = true)
    {
        if ($asString) {
            return (string) $this->color;
        }

        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(?string $color): RAFontInterface
    {
        $this->color->setColor($color);

        return $this;
    }

    public function getAngle(): int
    {
        return $this->angle;
    }

    public function setAngle(int $angle): RAFontInterface
    {
        $this->angle = $angle;

        return $this;
    }

    public function setFontFile(string $fontFile): RAFontInterface
    {
        if (!file_exists($fontFile)) {
            throw new \InvalidArgumentException('Font file not exist');
        }
        $this->fontFile = $fontFile;

        return $this;
    }

    public function getFontFile(): string
    {
        return $this->fontFile;
    }

    public function isFontAvailable(): bool
    {
        if (is_string($this->fontFile)) {
            return file_exists($this->fontFile);
        }

        return false;
    }

    public function countLines(): int
    {
        return substr_count($this->text, \PHP_EOL) + 1;
    }

    public function setInitials(int $maxLetters = 2): RAFontInterface
    {
        $this->text->setInitials($maxLetters);

        return $this;
    }
}
