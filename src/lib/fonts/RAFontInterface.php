<?php
/**
 * This file is part of True Loaded.
 *
 * @link http://www.holbi.co.uk
 * @copyright Copyright (c) 2005 Holbi Group LTD
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

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
