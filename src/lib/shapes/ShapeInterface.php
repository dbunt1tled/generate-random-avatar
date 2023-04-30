<?php

namespace DBUnt1tled\RandomAvatar\lib\shapes;

use Intervention\Image\Image;
use DBUnt1tled\RandomAvatar\lib\fonts\RAFontInterface;
use DBUnt1tled\RandomAvatar\lib\shapes\property\BorderInterface;

interface ShapeInterface
{
    public function getName(): string;

    public function setBackground(string $color): self;

    public function setBorder(int $width, ?string $color): self;

    public function getBackground(bool $asString = true);

    public function getBorder(): BorderInterface;

    public function hasBorder(): bool;

    public function getWidth(): int;

    public function getHeight(): int;

    public function setWidth(int $width): self;

    public function setHeight(int $height): self;

    public function isRound(): bool;

    public function applyImage(Image $image): void; // TODO need Refactoring

    public function applyImageText(Image $image, RAFontInterface $font): void; // TODO need Refactoring
}
