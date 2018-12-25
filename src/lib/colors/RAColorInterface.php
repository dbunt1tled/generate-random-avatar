<?php

namespace DBUnt1tled\RandomAvatar\lib\colors;

interface RAColorInterface
{
    public function __construct(string $color = null);
    public function getColor(): string;
    public function setColor(string $color): RAColorInterface;
    public function setRandomColor(): RAColorInterface;
}
