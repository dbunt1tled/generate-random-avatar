<?php

namespace DBUnt1tled\Test;

use PHPUnit\Framework\TestCase;
use DBUnt1tled\RandomAvatar\lib\colors\RAColorInterface;
use DBUnt1tled\RandomAvatar\lib\shapes\classes\RAEllipse;

class RAEllipseTest extends TestCase
{
    /** @var string */
    private $patternColor = '/#([a-f0-9]{6})\b/i';

    public function testConstruct()
    {
        $ellipse = new RAEllipse();
        $this->assertEquals(80, $ellipse->getWidth());
        $this->assertEquals(80, $ellipse->getHeight());
        $this->assertMatchesRegularExpression($this->patternColor, $ellipse->getBackground());

        $ellipse = new RAEllipse(3);
        $this->assertEquals(3, $ellipse->getWidth());
        $this->assertEquals(80, $ellipse->getHeight());
        $this->assertMatchesRegularExpression($this->patternColor, $ellipse->getBackground());

        $ellipse = new RAEllipse(3, 5);
        $this->assertEquals(3, $ellipse->getWidth());
        $this->assertEquals(5, $ellipse->getHeight());
        $this->assertMatchesRegularExpression($this->patternColor, $ellipse->getBackground());

        $ellipse = new RAEllipse(3, 5, '#4df');
        $this->assertEquals(3, $ellipse->getWidth());
        $this->assertEquals(5, $ellipse->getHeight());
        $this->assertEquals('#44DDFF', $ellipse->getBackground());
    }

    public function testSetBackground()
    {
        $ellipse = new RAEllipse();
        $ellipse->setBackground('#ee1');
        $class = new \ReflectionClass($ellipse->getBackground(false));
        $this->assertTrue($class->implementsInterface(RAColorInterface::class));
        $this->assertEquals('#EEEE11', $ellipse->getBackground());
    }

    public function testSetWidth()
    {
        $ellipse = new RAEllipse();
        $ellipse->setWidth(4);
        $this->assertEquals(4, $ellipse->getWidth());
    }

    public function testSetHeight()
    {
        $ellipse = new RAEllipse();
        $ellipse->setHeight(3);
        $this->assertEquals(3, $ellipse->getHeight());
    }

    public function testSetBorder()
    {
        $ellipse = new RAEllipse();
        $ellipse->setBorder(3, '#aaa');

        $this->assertEquals(3, $ellipse->getBorder()->getWidth());
        $this->assertTrue($ellipse->hasBorder());
        $this->assertEquals('#AAAAAA', $ellipse->getBorder()->getColor());

        $ellipse->setBorder(2);
        $this->assertEquals(2, $ellipse->getBorder()->getWidth());
        $this->assertTrue($ellipse->hasBorder());
        $this->assertMatchesRegularExpression($this->patternColor, $ellipse->getBorder()->getColor());
        $this->assertNotEquals('#AAAAAA', $ellipse->getBorder()->getColor());
    }
}
