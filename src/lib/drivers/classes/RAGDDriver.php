<?php

namespace DBUnt1tled\RandomAvatar\lib\drivers\classes;

use DBUnt1tled\RandomAvatar\lib\drivers\RADriverInterface;

class RAGDDriver implements RADriverInterface
{
    public const DRIVER_NAME = 'gd';

    public static function isAvailable(): bool
    {
        return extension_loaded(static::DRIVER_NAME);
    }

    public function getName(): string
    {
        return static::DRIVER_NAME;
    }

    public function checkAvailable(): bool
    {
        return extension_loaded($this->getName());
    }
}
