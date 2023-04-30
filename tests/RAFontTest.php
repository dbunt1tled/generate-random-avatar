<?php

namespace DBUnt1tled\Test;

use PHPUnit\Framework\TestCase;
use DBUnt1tled\RandomAvatar\lib\fonts\RAFont;
use DBUnt1tled\RandomAvatar\lib\colors\RAColorInterface;

class RAFontTest extends TestCase
{
    public function testConstruct()
    {
        $font = new RAFont('Sidorov Ivan Petrovich');
        $this->assertEquals('Sidorov Ivan Petrovich', $font->getText());

        $font = new RAFont('Sidorov Ivan Petrovich', '#abc');
        $this->assertEquals('Sidorov Ivan Petrovich', $font->getText());
        $this->assertEquals('#AABBCC', $font->getColor());

        $font = new RAFont('Sidorov Ivan Petrovich', '#abc', 20);
        $this->assertEquals('Sidorov Ivan Petrovich', $font->getText());
        $this->assertEquals('#AABBCC', $font->getColor());
        $this->assertEquals(20, $font->getSize());

        $font = new RAFont('Sidorov Ivan Petrovich', '#abc', 20, 5);
        $this->assertEquals('Sidorov Ivan Petrovich', $font->getText());
        $this->assertEquals('#AABBCC', $font->getColor());
        $this->assertEquals(20, $font->getSize());
        $this->assertEquals(5, $font->getAngle());
    }

    public function testSetInitials()
    {
        $font = new RAFont('Sidorov Ivan Petrovich');
        $font->setInitials(3);
        $this->assertEquals('SIP', $font->getText());
        $font = new RAFont('Sidorov Ivan Petrovich');
        $font->setInitials();
        $this->assertEquals('SI', $font->getText());
        $font = new RAFont('SidorovIvanPetrovich');
        $font->setInitials();
        $this->assertEquals('S', $font->getText());
    }

    public function testSetText()
    {
        $font = new RAFont('Sidorov Ivan Petrovich');
        $font->setText('Alan Bezotcetnuj');
        $this->assertEquals('Alan Bezotcetnuj', $font->getText());
    }

    public function testSetSize()
    {
        $font = new RAFont();
        $font->setSize(5);
        $this->assertEquals(5, $font->getSize());
    }

    public function testSetAngle()
    {
        $font = new RAFont();
        $font->setAngle(3);
        $this->assertEquals(3, $font->getAngle());
    }

    public function testSetFontFile()
    {
        $font = new RAFont();
        $font->setFontFile(realpath(__DIR__).'/data/myriadpro_reg.ttf');
        $this->assertTrue($font->isFontAvailable());
    }

    public function testSetColor()
    {
        $font = new RAFont();
        $font->setColor('#ffa');
        $class = new \ReflectionClass($font->getColor(false));
        $this->assertTrue($class->implementsInterface(RAColorInterface::class));
        $this->assertEquals('#FFFFAA', $font->getColor());
    }
}
