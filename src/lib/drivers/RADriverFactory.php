<?php

namespace DBUnt1tled\RandomAvatar\lib\drivers;

class RADriverFactory
{
    public const DRIVER_GD = 'gd';
    public const DRIVER_IMAGE_MAGICK = 'imagick';
    /** @var array */
    private $drivers = [];

    public function __construct()
    {
        $dirClasses = realpath(__DIR__) . '/classes';
        $namespaceClasses = __NAMESPACE__ . '\\classes\\';
        $fileClasses = $this->getDirContents($dirClasses);
        foreach ($fileClasses as $file) {
            $class = $namespaceClasses . $file['class'];
            if ($this->checkDriver($class)) {
                $this->addDriver($class::DRIVER_NAME, $class);
            }
        }
    }

    /**
     * @param string $name
     * @param string $class
     * @return RADriverFactory
     * @throws \ReflectionException
     */
    public function addDriver(string $name, string $class): RADriverFactory
    {
        $driver = new \ReflectionClass($class);
        if (!$driver->implementsInterface(RADriverInterface::class)) {
            throw new \InvalidArgumentException($name . ' is not driver');
        }
        $this->drivers[$name] = $class;
        return $this;
    }

    /**
     * @param RADriverInterface $driver
     * @return RADriverFactory
     */
    public function addDriverObj(RADriverInterface $driver): RADriverFactory
    {
        $this->drivers[$driver->getName()] = get_class($driver);
        return $this;
    }
    /**
     * @param string $name
     * @return RADriverFactory
     */
    public function deleteDriver(string $name): RADriverFactory
    {
        if (!$this->isDriverAvailable($name)) {
            throw new \InvalidArgumentException('Driver '. $name - ' not available.');
        }
        unset($this->drivers[$name]);
        return $this;
    }

    /**
     * @return array
     */
    public function getAvailableDrivers(): array
    {
        return array_keys($this->drivers);
    }

    /**
     * @param string $name
     * @return RADriverInterface
     */
    public function getDriverObject(string $name): RADriverInterface
    {
        if (!$this->isDriverAvailable($name)) {
            throw new \InvalidArgumentException('Driver '. $name - ' not available.');
        }
        return new $this->drivers[$name]();
    }

    /**
     * @param string $name
     * @return string
     */
    public function getDriverClassName(string $name): string
    {
        if (!$this->isDriverAvailable($name)) {
            throw new \InvalidArgumentException('Driver '. $name - ' not available.');
        }
        return $this->drivers[$name];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function isDriverAvailable(string $name): bool
    {
        return array_key_exists($name, $this->drivers);
    }

    /**
     * @return string
     */
    public function getFirstAvailableDriver(): string
    {
        foreach ($this->drivers as $driver) {
            if ($this->checkDriver($driver)) {
                return $driver;
            }
        }
        throw new \RuntimeException('Not Available Drivers');
    }

    /**
     * @return RADriverInterface
     */
    public function getFirstAvailableDriverObj(): RADriverInterface
    {
        $class = $this->getFirstAvailableDriver();
        return new $class();
    }

    /**
     * @param string $path
     * @return array
     */
    private function getDirContents(string $path): array
    {
        $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));

        $files = [];
        foreach ($rii as $file) {
            /** @var $file \SplFileInfo  */
            if (!$file->isDir() && $file->getExtension() === 'php') {
                $files[] = [
                    'path' => $file->getPathname(),
                    'file' => $file->getFilename(),
                    'class' => $file->getBasename('.' . $file->getExtension()),
                ];
            }
        }
        return $files;
    }

    /**
     * @param string $driver
     * @return bool
     */
    private function checkDriver(string $driver): bool
    {
        return (defined("$driver::DRIVER_NAME") && !empty($driver::DRIVER_NAME) && method_exists($driver, 'isAvailable') && $driver::isAvailable());
    }
}
