<?php
/**
 * This file is part of True Loaded.
 *
 * @link http://www.holbi.co.uk
 * @copyright Copyright (c) 2005 Holbi Group LTD
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace DBUnt1tled\RandomAvatar\lib\shapes;

use DBUnt1tled\RandomAvatar\lib\fonts\RAFontInterface;
use DBUnt1tled\RandomAvatar\lib\shapes\property\BorderInterface;
use Intervention\Image\Image;

interface ShapeInterface
{
    public function getName(): string;
    public function setBackground(string $color): ShapeInterface;
    public function setBorder(int $width, ?string $color): ShapeInterface;
    public function getBackground(bool $asString = true);
    public function getBorder(): BorderInterface;
    public function hasBorder(): bool;
    public function getWidth(): int;
    public function getHeight(): int;
    public function setWidth(int $width): ShapeInterface;
    public function setHeight(int $height): ShapeInterface;
    public function isRound(): bool;
    public function applyImage(Image $image): void; // TODO need Refactoring
    public function applyImageText(Image $image, RAFontInterface $font): void; // TODO need Refactoring
}
