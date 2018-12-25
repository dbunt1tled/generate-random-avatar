<?php

namespace DBUnt1tled\Test;

use DBUnt1tled\Test\data\RADumpDriver;
use DBUnt1tled\RandomAvatar\lib\drivers\RADriverFactory;
use PHPUnit\Framework\TestCase;
use DBUnt1tled\RandomAvatar\lib\drivers\RADriverInterface;
use DBUnt1tled\RandomAvatar\lib\drivers\classes\RAGDDriver;
use DBUnt1tled\RandomAvatar\lib\drivers\classes\RAImageMagickDriver;

class RADriverFactoryTest extends TestCase
{

    public function testGetFirstAvailableDriverObj()
    {
        $driverFactory = new RADriverFactory();
        $driverObject = $driverFactory->getFirstAvailableDriverObj();
        $this->assertIsObject($driverObject);
        $this->assertInstanceOf(RADriverInterface::class,$driverObject);
    }

    public function testGetFirstAvailableDriver()
    {
        $driverFactory = new RADriverFactory();
        $driverObject = $driverFactory->getFirstAvailableDriver();
        $class = new \ReflectionClass($driverObject);
        $this->assertTrue($class->implementsInterface(RADriverInterface::class));

    }

    public function testAddDriver()
    {
        $driverFactory = new RADriverFactory();
        $driverFactory->addDriver(RADumpDriver::DRIVER_NAME, RADumpDriver::class);
        $this->assertTrue($driverFactory->isDriverAvailable(RADumpDriver::DRIVER_NAME));
    }

    public function testAddDriverObj()
    {
        $driverFactory = new RADriverFactory();
        $driver = new RADumpDriver();
        $driverFactory->addDriverObj($driver);
        $this->assertTrue($driverFactory->isDriverAvailable(RADumpDriver::DRIVER_NAME));
    }

    public function testDeleteDriver()
    {
        $driverFactory = new RADriverFactory();
        $driver = new RADumpDriver();
        $driverFactory->addDriverObj($driver);
        $this->assertTrue($driverFactory->isDriverAvailable(RADumpDriver::DRIVER_NAME));
        $driverFactory->deleteDriver(RADumpDriver::DRIVER_NAME);
        $this->assertFalse($driverFactory->isDriverAvailable(RADumpDriver::DRIVER_NAME));
    }


    public function testGetDriverObject()
    {
        $driverFactory = new RADriverFactory();
        $driverObject = $driverFactory->getDriverObject(RADriverFactory::DRIVER_GD);
        $this->assertIsObject($driverObject);
        $this->assertInstanceOf(RAGDDriver::class,$driverObject);
        $driverObject = $driverFactory->getDriverObject(RADriverFactory::DRIVER_IMAGE_MAGICK);
        $this->assertIsObject($driverObject);
        $this->assertInstanceOf(RAImageMagickDriver::class,$driverObject);
    }

    public function testGetAvailableDrivers()
    {
        $driverFactory = new RADriverFactory();
        $driver = array_flip($driverFactory->getAvailableDrivers());
        $this->assertArrayHasKey(RADriverFactory::DRIVER_GD, $driver);
        $this->assertArrayHasKey(RADriverFactory::DRIVER_IMAGE_MAGICK, $driver);
    }

    public function testGetDriverClassName()
    {
        $driverFactory = new RADriverFactory();
        $driver = $driverFactory->getDriverClassName(RADriverFactory::DRIVER_GD);
        $this->assertIsString($driver);
        $class = new \ReflectionClass($driver);
        $this->assertTrue($class->implementsInterface(RADriverInterface::class));
    }

    public function testIsDriverAvailable()
    {
        $driverFactory = new RADriverFactory();
        $this->assertTrue($driverFactory->isDriverAvailable(RADriverFactory::DRIVER_GD));
        $this->assertTrue($driverFactory->isDriverAvailable(RADriverFactory::DRIVER_IMAGE_MAGICK));
        $this->assertFalse($driverFactory->isDriverAvailable('dump'));
    }

}
