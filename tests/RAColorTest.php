<?php

namespace DBUnt1tled\Test;

use PHPUnit\Framework\TestCase;
use DBUnt1tled\RandomAvatar\lib\colors\RAColor;

class RAColorTest extends TestCase
{
    /** @var string */
    private $patternColor = '/#([a-f0-9]{6})\b/i';

    public function testValidateColor()
    {
        $color = new RAColor();
        $this->assertTrue($color->validateColor('#aaa'));
        $this->assertTrue($color->validateColor('#aAa0E4'));
        $this->assertTrue($color->validateColor('#012345'));
        $this->assertFalse($color->validateColor('#aaaa'));
        $this->assertFalse($color->validateColor('#aga'));
        $this->assertFalse($color->validateColor('#0123456'));
    }

    public function testSetColor()
    {
        $color = new RAColor();
        $color->setColor(null);
        $this->assertMatchesRegularExpression($this->patternColor, $color->getColor());
        $color->setColor('#0aC');
        $this->assertEquals('#00AACC', $color->getColor());
        $color->setColor('#0aC1');
        $this->assertNotEquals('#0aC1', $color->getColor());
        $this->assertMatchesRegularExpression($this->patternColor, $color->getColor());
    }

    public function testSetRandomColor()
    {
        $color = new RAColor();
        $colorTmp = $color->getColor();
        $color->setRandomColor();
        $this->assertMatchesRegularExpression($this->patternColor, $color->getColor());
        $this->assertNotEquals($colorTmp, $color->getColor());
    }

    public function testSetColorFromBackground()
    {
        $color = new RAColor();
        $color->setColorFromBackground('#000000');
        $this->assertEquals('#FFFFFF', $color->getColor());
        $color->setColorFromBackground('#0000001');
        $this->assertEquals('#000000', $color->getColor());
    }

    public function testConstruct()
    {
        $color = new RAColor('#fff');
        $this->assertEquals('#FFFFFF', $color->getColor());
        $color = new RAColor('#ABCDEF');
        $this->assertEquals('#ABCDEF', $color->getColor());
        $color = new RAColor('#ABCDEFF');
        $this->assertMatchesRegularExpression($this->patternColor, $color->getColor());
        $this->assertNotEquals('#ABCDEFF', $color->getColor());
    }
}
