<?php

namespace DBUnt1tled\RandomAvatar\lib\colors;

class RAColor implements RAColorInterface
{
    /** @var string */
    private $color;

    /**
     * RAColor constructor.
     */
    public function __construct(string $color = null)
    {
        if (null === $color) {
            $this->setRandomColor();
        } else {
            $this->setColor($color);
        }
    }

    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(string $color = null): RAColorInterface
    {
        if (!$this->validateColor($color)) {
            $color = $this->getRandomColor();
        }

        if (4 === mb_strlen($color)) {
            $color = $this->convert3To6DigitColor($color);
        }
        $color = mb_strtoupper($color);
        $this->color = $color;

        return $this;
    }

    public function setRandomColor(): RAColorInterface
    {
        return $this->setColor($this->getRandomColor());
    }

    /**
     * @param bool $sendException
     */
    public function getRandomColor(bool $sendException = null): string
    {
        $rand = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F'];

        try {
            $color = '#'.$rand[random_int(0, 15)].$rand[random_int(0, 15)].$rand[random_int(0, 15)].$rand[random_int(0, 15)].$rand[random_int(0, 15)].$rand[random_int(0, 15)];
        } catch (\Exception $exception) {
            if ($sendException) {
                throw new \RuntimeException($exception->getMessage());
            }
            $color = $color = '#'.$rand[mt_rand(0, 15)].$rand[mt_rand(0, 15)].$rand[mt_rand(0, 15)].$rand[mt_rand(0, 15)].$rand[mt_rand(0, 15)].$rand[mt_rand(0, 15)];
        }

        return $color;
    }

    public function getColorFromBackground(string $bgColor): string
    {
        if ($this->colorLuminanceHex($bgColor) < 128) {
            return '#FFFFFF';
        }

        return '#000000';
    }

    /**
     * @param string|null $bgColor
     */
    public function setColorFromBackground(string $bgColor): RAColorInterface
    {
        return $this->setColor($this->getColorFromBackground($bgColor));
    }

    public function validateColor(string $color = null): bool
    {
        if (null === $color) {
            return false;
        }

        return 0 !== preg_match('/#([a-f0-9]{3}){1,2}\b/i', $color);
    }

    public function convert3To6DigitColor(string $color): string
    {
        return '#'.$color[1].$color[1].$color[2].$color[2].$color[3].$color[3];
    }

    public function getInverseColor(string $color = null): string
    {
        $color = $color ?? $this->getColor();

        $color = str_replace('#', '', (string) $color);
        if (6 !== strlen($color)) {
            return '000000';
        }
        $rgb = '';
        for ($x = 0; $x < 3; ++$x) {
            $c = 255 - hexdec(substr($color, 2 * $x, 2));
            $c = ($c < 0) ? 0 : dechex($c);
            $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
        }

        return '#'.$rgb;
    }

    public function __toString(): string
    {
        return $this->getColor();
    }

    private function colorLuminanceHex(string $color = null): int
    {
        $color = $color ?? $this->getColor();
        if (!$this->validateColor($color)) {
            return 255;
        }
        $hex = str_replace('#', '', $color);
        $luminance = 0.3 * hexdec(substr($hex, 0, 2)) + 0.59 * hexdec(substr($hex, 2, 2)) + 0.11 * hexdec(substr($hex, 4, 2));

        return $luminance;
    }
}
