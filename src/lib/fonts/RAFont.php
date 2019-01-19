<?php

namespace DBUnt1tled\RandomAvatar\lib\fonts;

use DBUnt1tled\RandomAvatar\lib\colors\RAColorInterface;
use DBUnt1tled\RandomAvatar\lib\colors\RAColor;
use DBUnt1tled\RandomAvatar\lib\fonts\property\RAText;
use DBUnt1tled\RandomAvatar\lib\fonts\property\TextInterface;

class RAFont implements RAFontInterface
{
    /** @var TextInterface */
    private $text;
    /** @var int $size */
    private $size;
    /** @var RAColorInterface */
    private $color;
    /** @var int $angle */
    private $angle;
    /** @var string $fontFile */
    private $fontFile;

    /**
     * RAFont constructor.
     * @param string|null $text
     * @param string|null $color
     * @param int $size
     * @param int $angle
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
        $this->fontFile = realpath(__DIR__) . '/../../fonts/Roboto-Regular.ttf';
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return (string)$this->text;
    }

    /**
     * @param string $text
     * @return RAFontInterface
     */
    public function setText(string $text): RAFontInterface
    {
        $this->text->setText($text);
        return $this;
    }

    /**
     * @return int
     */
    public function getSize():int
    {
        return $this->size;
    }

    /**
     * @param int $size
     * @return RAFontInterface
     */
    public function setSize(int $size): RAFontInterface
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @param bool $asString
     * @return RAColor|RAColorInterface|string
     */
    public function getColor(bool $asString = true)
    {
        if ($asString) {
            return (string)$this->color;
        }
        return $this->color;
    }

    /**
     * @param string $color
     * @return RAFontInterface
     */
    public function setColor(?string $color): RAFontInterface
    {
        $this->color->setColor($color);
        return $this;
    }

    /**
     * @return int
     */
    public function getAngle(): int
    {
        return $this->angle;
    }

    /**
     * @param int $angle
     * @return RAFontInterface
     */
    public function setAngle(int $angle): RAFontInterface
    {
        $this->angle = $angle;
        return $this;
    }

    /**
     * @param string $fontFile
     * @return RAFontInterface
     */
    public function setFontFile(string $fontFile): RAFontInterface
    {
        if (!file_exists($fontFile)) {
            throw new \InvalidArgumentException('Font file not exist');
        }
        $this->fontFile = $fontFile;
        return $this;
    }

    /**
     * @return string
     */
    public function getFontFile(): string
    {
        return $this->fontFile;
    }

    /**
     * @return bool
     */
    public function isFontAvailable(): bool
    {
        if (is_string($this->fontFile)) {
            return file_exists($this->fontFile);
        }

        return false;
    }

    /**
     * @return int
     */
    public function countLines(): int
    {
        return substr_count($this->text, PHP_EOL) + 1;
    }

    /**
     * @param int $maxLetters
     * @return RAFontInterface
     */
    public function setInitials(int $maxLetters = 2): RAFontInterface
    {
        $this->text->setInitials($maxLetters);
        return $this;
    }
}
