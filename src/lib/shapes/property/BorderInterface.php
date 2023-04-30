<?php

namespace DBUnt1tled\RandomAvatar\lib\shapes\property;

interface BorderInterface
{
    public function getColor(bool $asString = true);

    public function setColor(?string $color): self;

    public function getWidth(): int;

    public function setWidth(?int $width): self;

    public function hasBorder(): bool;
}
