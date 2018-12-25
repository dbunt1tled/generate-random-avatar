<?php
/**
 * This file is part of True Loaded.
 *
 * @link http://www.holbi.co.uk
 * @copyright Copyright (c) 2005 Holbi Group LTD
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace DBUnt1tled\RandomAvatar\lib\fonts\property;

interface TextInterface
{
    public function __construct(string $text);
    public function setText(string $text): TextInterface;
    public function getText(): string;
    public function setInitials(int $maxLetters = 2): TextInterface;
}
