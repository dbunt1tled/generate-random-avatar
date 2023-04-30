<?php

namespace DBUnt1tled\RandomAvatar\lib\fonts;

interface RAFontInterface
{
    public function setText(string $text): self;

    public function setInitials(): self;

    public function getText(): string;

    public function setSize(int $size): self;

    public function getSize(): int;

    public function setColor(string $color): self;

    public function getColor(bool $asString = true);

    public function setAngle(int $angle): self;

    public function getAngle(): int;

    public function isFontAvailable(): bool;

    public function setFontFile(string $fontFile): self;

    public function getFontFile(): string;

    public function countLines(): int;
}
