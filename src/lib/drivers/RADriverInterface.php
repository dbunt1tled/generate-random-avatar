<?php

namespace DBUnt1tled\RandomAvatar\lib\drivers;

interface RADriverInterface
{
    public function getName(): string;
    public function checkAvailable(): bool;
}
