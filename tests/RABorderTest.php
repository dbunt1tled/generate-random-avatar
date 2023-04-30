<?php

namespace DBUnt1tled\Test;

use PHPUnit\Framework\TestCase;
use DBUnt1tled\RandomAvatar\lib\shapes\property\RABorder;

class RABorderTest extends TestCase
{
    /** @var string */
    private $patternColor = '/#([a-f0-9]{6})\b/i';

    public function testSetColor()
    {
        $border = new RABorder();
        $this->assertMatchesRegularExpression($this->patternColor, $border->getColor());
        $border->setColor('#a0f');
        $this->assertEquals('#AA00FF', $border->getColor());
        $border->setColor(null);
        $this->assertMatchesRegularExpression($this->patternColor, $border->getColor());
        $border->setColor('zrada');
        $this->assertMatchesRegularExpression($this->patternColor, $border->getColor());
    }

    public function testSetWidth()
    {
        $border = new RABorder();
        $this->assertEquals(0, $border->getWidth());
        $border->setWidth(3);
        $this->assertEquals(3, $border->getWidth());
    }

    public function testHasBorder()
    {
        $border = new RABorder();
        $this->assertFalse($border->hasBorder());
        $border->setWidth(1);
        $this->assertTrue($border->hasBorder());
        $border->setWidth(-1);
        $this->assertTrue($border->hasBorder());
        $border->setWidth(0);
        $this->assertFalse($border->hasBorder());
    }

    public function testConstruct()
    {
        $border = new RABorder();
        $this->assertFalse($border->hasBorder());
        $this->assertEquals(0, $border->getWidth());
        $this->assertMatchesRegularExpression('/#([a-f0-9]{6})\b/i', $border->getColor());

        $border = new RABorder(3);
        $this->assertTrue($border->hasBorder());
        $this->assertEquals(3, $border->getWidth());
        $this->assertMatchesRegularExpression('/#([a-f0-9]{6})\b/i', $border->getColor());

        $border = new RABorder(null, '#00FFEE');
        $this->assertFalse($border->hasBorder());
        $this->assertEquals(0, $border->getWidth());
        $this->assertEquals('#00FFEE', $border->getColor());

        $border = new RABorder(3, '#abc');
        $this->assertTrue($border->hasBorder());
        $this->assertEquals(3, $border->getWidth());
        $this->assertEquals('#AABBCC', $border->getColor());

        $border = new RABorder(4, '#abcd');
        $this->assertTrue($border->hasBorder());
        $this->assertEquals(4, $border->getWidth());
        $this->assertMatchesRegularExpression('/#([a-f0-9]{6})\b/i', $border->getColor());
    }
}
