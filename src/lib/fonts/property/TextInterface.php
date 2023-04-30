<?php

namespace DBUnt1tled\RandomAvatar\lib\fonts\property;

interface TextInterface
{
    public function __construct(string $text);

    public function setText(string $text): self;

    public function getText(): string;

    public function setInitials(int $maxLetters = 2): self;
}
