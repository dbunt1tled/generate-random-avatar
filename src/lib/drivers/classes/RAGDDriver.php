<?php

namespace DBUnt1tled\RandomAvatar\lib\drivers\classes;

use DBUnt1tled\RandomAvatar\lib\drivers\RADriverInterface;

class RAGDDriver implements RADriverInterface
{
    public const DRIVER_NAME = 'gd';

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::DRIVER_NAME;
    }

    /**
     * @return bool
     */
    public function checkAvailable(): bool
    {
        return extension_loaded($this->getName());
    }

    /**
     * @return bool
     */
    public static function isAvailable(): bool
    {
        return extension_loaded(static::DRIVER_NAME);
    }
}
