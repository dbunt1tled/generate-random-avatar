<?php

namespace DBUnt1tled\Test;

use PHPUnit\Framework\TestCase;
use DBUnt1tled\RandomAvatar\RAvatar;
use DBUnt1tled\Test\data\RADumpShape;
use DBUnt1tled\Test\data\RADumpDriver;
use DBUnt1tled\RandomAvatar\lib\fonts\RAFont;
use DBUnt1tled\RandomAvatar\lib\fonts\RAFontInterface;
use DBUnt1tled\RandomAvatar\lib\shapes\ShapeInterface;
use DBUnt1tled\RandomAvatar\lib\shapes\classes\RAEllipse;
use DBUnt1tled\RandomAvatar\lib\drivers\RADriverInterface;
use DBUnt1tled\RandomAvatar\lib\drivers\classes\RAGDDriver;
use DBUnt1tled\RandomAvatar\lib\shapes\classes\RARectangle;
use DBUnt1tled\RandomAvatar\lib\drivers\classes\RAImageMagickDriver;

class RAvatarTest extends TestCase
{
    /** @var string */
    private $patternColor = '/#([a-f0-9]{6})\b/i';

    public function testConstruct()
    {
        $avatar = new RAvatar();
        $class = new \ReflectionClass($avatar->getDriver());
        $this->assertTrue($class->implementsInterface(RADriverInterface::class));
        $class = new \ReflectionClass($avatar->getFigure());
        $this->assertTrue($class->implementsInterface(ShapeInterface::class));
        $class = new \ReflectionClass($avatar->getFont());
        $this->assertTrue($class->implementsInterface(RAFontInterface::class));

        $avatar = new RAvatar(new RADumpShape());
        $this->assertInstanceOf(RADumpShape::class, $avatar->getFigure());

        $avatar = new RAvatar(new RADumpShape(), new RAFont());
        $this->assertInstanceOf(RADumpShape::class, $avatar->getFigure());
        $this->assertInstanceOf(RAFont::class, $avatar->getFont());

        $avatar = new RAvatar(new RADumpShape(), new RAFont(), new RADumpDriver());

        $this->assertInstanceOf(RADumpShape::class, $avatar->getFigure());
        $this->assertInstanceOf(RAFont::class, $avatar->getFont());
        $this->assertInstanceOf(RADumpDriver::class, $avatar->getDriver());
    }

    public function testSetFigure()
    {
        $avatar = new RAvatar();
        $this->assertNotInstanceOf(RADumpShape::class, $avatar->getFigure());
        $avatar->setFigure(new RADumpShape());
        $this->assertInstanceOf(RADumpShape::class, $avatar->getFigure());
    }

    public function testSetShape()
    {
        $avatar = (new RAvatar())->setShape(RAEllipse::SHAPE_NAME, 40, 39, '#aaa');
        $shape = $avatar->getFigure();
        $this->assertInstanceOf(RAEllipse::class, $shape);
        $this->assertEquals(40, $shape->getWidth());
        $this->assertEquals(39, $shape->getHeight());
        $this->assertEquals('#AAAAAA', $shape->getBackground());
        $this->assertEquals(RAEllipse::SHAPE_NAME, $shape->getName());
    }

    public function testSetText()
    {
        $avatar = (new RAvatar())->setText('Alexandr Petrov');
        $this->assertEquals('Alexandr Petrov', $avatar->getFont()->getText());
    }

    public function testSetDriverGD()
    {
        $avatar = (new RAvatar())->setDriverGD();
        $this->assertEquals(RAGDDriver::DRIVER_NAME, $avatar->getDriver()->getName());
    }

    public function testSetDriverImageMagick()
    {
        $avatar = (new RAvatar())->setDriverImageMagick();
        $this->assertEquals(RAImageMagickDriver::DRIVER_NAME, $avatar->getDriver()->getName());
    }

    public function testSetInverseColorText()
    {
        $avatar = (new RAvatar())
            ->setText('GD', '#AAAAAA')
            ->setShape(RARectangle::SHAPE_NAME, 60, 60, '#000000');
        $font = $avatar->getFont();
        $shape = $avatar->getFigure();

        $this->assertEquals('#AAAAAA', $font->getColor());
        $this->assertEquals('#000000', $shape->getBackground());

        $avatar->setInverseColorText();
        $font = $avatar->getFont();
        $this->assertNotEquals('#AAAAAA', $font->getColor());
        $this->assertEquals('#FFFFFF', $font->getColor());

        $avatar
            ->setBackGroundColor('#FFFFFF')
            ->setInverseColorText();
        $font = $avatar->getFont();
        $this->assertNotEquals('#FFFFFF', $font->getColor());
        $this->assertEquals('#000000', $font->getColor());
    }

    public function testSetBackgroundColor()
    {
        $avatar = (new RAvatar())->setShape(RARectangle::SHAPE_NAME, 60, 60, '#000000');

        $shape = $avatar->getFigure();
        $this->assertEquals('#000000', $shape->getBackground());
        $avatar->setBackGroundColor('#EEEEEE');

        $shape = $avatar->getFigure();
        $this->assertNotEquals('#000000', $shape->getBackground());
        $this->assertEquals('#EEEEEE', $shape->getBackground());

        $avatar->setBackGroundColor();
        $shape = $avatar->getFigure();
        $this->assertNotEquals('#EEEEEE', $shape->getBackground());
        $this->assertMatchesRegularExpression($this->patternColor, $shape->getBackground());
    }

    public function testSetTextColor()
    {
        $avatar = (new RAvatar())->setText('Random', '#000000');

        $font = $avatar->getFont();
        $this->assertEquals('#000000', $font->getColor());
        $avatar->setTextColor('#EEEEEE');

        $font = $avatar->getFont();
        $this->assertNotEquals('#000000', $font->getColor());
        $this->assertEquals('#EEEEEE', $font->getColor());

        $avatar->setTextColor();
        $font = $avatar->getFont();
        $this->assertNotEquals('#EEEEEE', $font->getColor());
        $this->assertMatchesRegularExpression($this->patternColor, $font->getColor());
    }

    public function testSetInitials()
    {
        $avatar = (new RAvatar())
                    ->setText('Alexandr Petrov')
                    ->setInitials();
        $this->assertEquals('AP', $avatar->getFont()->getText());
    }

    public function testSetDriverFromName()
    {
        $avatar = (new RAvatar())->setDriverFromName(RAImageMagickDriver::DRIVER_NAME);
        $this->assertEquals(RAImageMagickDriver::DRIVER_NAME, $avatar->getDriver()->getName());
    }

    public function testSetBorder()
    {
        $avatar = (new RAvatar())->setBorder(3, '#0AB');
        $shape = $avatar->getFigure();
        $this->assertTrue($shape->hasBorder());
        $this->assertEquals(3, $shape->getBorder()->getWidth());
        $this->assertEquals('#00AABB', $shape->getBorder()->getColor());
    }

    public function testSetDriver()
    {
        $avatar = (new RAvatar())->setDriver(new RADumpDriver());
        $this->assertEquals(RADumpDriver::DRIVER_NAME, $avatar->getDriver()->getName());
        $this->assertInstanceOf(RADumpDriver::class, $avatar->getDriver());
    }

    public function testSetFont()
    {
        $avatar = (new RAvatar())->setFont(
            (new RAFont())->setText('Petr Snigerev')
        );
        $this->assertInstanceOf(RAFont::class, $avatar->getFont());
        $this->assertEquals('Petr Snigerev', $avatar->getFont()->getText());
    }
}
