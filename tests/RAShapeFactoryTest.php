<?php

namespace DBUnt1tled\Test;

use PHPUnit\Framework\TestCase;
use DBUnt1tled\Test\data\RADumpShape;
use DBUnt1tled\RandomAvatar\lib\shapes\RAShapeFactory;
use DBUnt1tled\RandomAvatar\lib\shapes\classes\RAEllipse;

class RAShapeFactoryTest extends TestCase
{
    public function testConstruct()
    {
        $shapeFactory = new RAShapeFactory();
        $this->assertIsArray($shapeFactory->getShapesAvailable());

        $this->assertTrue(class_exists($shapeFactory->getShapeClassName(RAEllipse::SHAPE_NAME)));
    }

    public function testAddShape()
    {
        $shapeFactory = new RAShapeFactory();
        $shapeFactory->addShape(RADumpShape::SHAPE_NAME, RADumpShape::class);
        $this->assertContains(RADumpShape::SHAPE_NAME, $shapeFactory->getShapesAvailable());
    }

    public function testAddShapeObj()
    {
        $shapeFactory = new RAShapeFactory();
        $shape = new RADumpShape();
        $shapeFactory->addShapeObj($shape);
        $this->assertContains(RADumpShape::SHAPE_NAME, $shapeFactory->getShapesAvailable());
    }

    public function testDeleteShape()
    {
        $shapeFactory = new RAShapeFactory();
        $shapeFactory->addShape(RADumpShape::SHAPE_NAME, RADumpShape::class);
        $this->assertContains(RADumpShape::SHAPE_NAME, $shapeFactory->getShapesAvailable());
        $shapeFactory->deleteShape(RADumpShape::SHAPE_NAME);
        $this->assertNotContains(RADumpShape::SHAPE_NAME, $shapeFactory->getShapesAvailable());
    }
}
