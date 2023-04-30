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
        $dirClasses = realpath(__DIR__).'/classes';
        $namespaceClasses = __NAMESPACE__.'\\classes\\';
        $fileClasses = $this->getDirContents($dirClasses);
        foreach ($fileClasses as $file) {
            $class = $namespaceClasses.$file['class'];
            if ($this->checkDriver($class)) {
                $this->addDriver($class::DRIVER_NAME, $class);
            }
        }
    }

    /**
     * @throws \ReflectionException
     */
    public function addDriver(string $name, string $class): self
    {
        $driver = new \ReflectionClass($class);
        if (!$driver->implementsInterface(RADriverInterface::class)) {
            throw new \InvalidArgumentException($name.' is not driver');
        }
        $this->drivers[$name] = $class;

        return $this;
    }

    public function addDriverObj(RADriverInterface $driver): self
    {
        $this->drivers[$driver->getName()] = $driver::class;

        return $this;
    }

    public function deleteDriver(string $name): self
    {
        if (!$this->isDriverAvailable($name)) {
            throw new \InvalidArgumentException('Driver '.$name - ' not available.');
        }
        unset($this->drivers[$name]);

        return $this;
    }

    public function getAvailableDrivers(): array
    {
        return array_keys($this->drivers);
    }

    public function getDriverObject(string $name): RADriverInterface
    {
        if (!$this->isDriverAvailable($name)) {
            throw new \InvalidArgumentException('Driver '.$name - ' not available.');
        }

        return new $this->drivers[$name]();
    }

    public function getDriverClassName(string $name): string
    {
        if (!$this->isDriverAvailable($name)) {
            throw new \InvalidArgumentException('Driver '.$name - ' not available.');
        }

        return $this->drivers[$name];
    }

    public function isDriverAvailable(string $name): bool
    {
        return array_key_exists($name, $this->drivers);
    }

    public function getFirstAvailableDriver(): string
    {
        foreach ($this->drivers as $driver) {
            if ($this->checkDriver($driver)) {
                return $driver;
            }
        }

        throw new \RuntimeException('Not Available Drivers');
    }

    public function getFirstAvailableDriverObj(): RADriverInterface
    {
        $class = $this->getFirstAvailableDriver();

        return new $class();
    }

    private function getDirContents(string $path): array
    {
        $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));

        $files = [];
        foreach ($rii as $file) {
            /** @var $file \SplFileInfo */
            if (!$file->isDir() && 'php' === $file->getExtension()) {
                $files[] = [
                    'path' => $file->getPathname(),
                    'file' => $file->getFilename(),
                    'class' => $file->getBasename('.'.$file->getExtension()),
                ];
            }
        }

        return $files;
    }

    private function checkDriver(string $driver): bool
    {
        return defined("$driver::DRIVER_NAME") && !empty($driver::DRIVER_NAME) && method_exists($driver, 'isAvailable') && $driver::isAvailable();
    }
}
