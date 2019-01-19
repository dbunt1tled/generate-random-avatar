<?php

namespace DBUnt1tled\RandomAvatar\lib\shapes\property;

interface BorderInterface
{
    public function getColor(bool $asString = true);
    public function setColor(?string $color): BorderInterface;
    public function getWidth(): int;
    public function setWidth(?int $width): BorderInterface;
    public function hasBorder(): bool;
}
