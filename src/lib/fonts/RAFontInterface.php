<?php

namespace DBUnt1tled\RandomAvatar\lib\fonts;

interface RAFontInterface
{
    public function setText(string $text): RAFontInterface;
    public function setInitials(): RAFontInterface;
    public function getText(): string;
    public function setSize(int $size): RAFontInterface;
    public function getSize(): int;
    public function setColor(string $color): RAFontInterface;
    public function getColor(bool $asString = true);
    public function setAngle(int $angle): RAFontInterface;
    public function getAngle(): int;
    public function isFontAvailable(): bool;
    public function setFontFile(string $fontFile): RAFontInterface;
    public function getFontFile(): string;
    public function countLines(): int;
}
