<?php

namespace DBUnt1tled\RandomAvatar\lib\shapes;

class RAShapeFactory
{
    /** @var array */
    private $shapes = [];


    public function __construct()
    {
        $dirClasses = realpath(__DIR__) . '/classes';
        $namespaceClasses = __NAMESPACE__ . '\\classes\\';
        $fileClasses = $this->getDirContents($dirClasses);
        foreach ($fileClasses as $file) {
            $class = $namespaceClasses . $file['class'];
            if (defined("$class::SHAPE_NAME") && !empty($class::SHAPE_NAME)) {
                $this->addShape($class::SHAPE_NAME, $class);
            }
        }
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
            /** @var \SplFileInfo $file */
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
     * @param string $name
     * @param string $class
     * @return RAShapeFactory
     * @throws \ReflectionException
     */
    public function addShape(string $name, string $class): RAShapeFactory
    {
        $shape = new \ReflectionClass($class);
        if (!$shape->implementsInterface(ShapeInterface::class)) {
            throw new \InvalidArgumentException($name . ' is not shape');
        }
        $this->shapes[$name] = $class;
        return $this;
    }

    /**
     * @param ShapeInterface $shape
     * @return RAShapeFactory
     */
    public function addShapeObj(ShapeInterface $shape): RAShapeFactory
    {
        $this->shapes[$shape->getName()] = get_class($shape);
        return $this;
    }

    /**
     * @param string $name
     * @return RAShapeFactory
     */
    public function deleteShape(string $name): RAShapeFactory
    {
        if (!$this->isShapeAvailable($name)) {
            throw new \InvalidArgumentException('Shape '. $name - ' not available.');
        }
        unset($this->shapes[$name]);
        return $this;
    }

    /**
     * @return array
     */
    public function getShapesAvailable(): array
    {
        return array_keys($this->shapes);
    }

    /**
     * @param string $name
     * @return ShapeInterface
     */
    public function getShapeObject(string $name): ShapeInterface
    {
        if (!$this->isShapeAvailable($name)) {
            throw new \InvalidArgumentException('Shape '. $name - ' not available.');
        }
        return new $this->shapes[$name]();
    }

    /**
     * @param string $name
     * @return string
     */
    public function getShapeClassName(string $name): string
    {
        if (!$this->isShapeAvailable($name)) {
            throw new \InvalidArgumentException('Shape '. $name - ' not available.');
        }
        return $this->shapes[$name];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function isShapeAvailable(string $name): bool
    {
        return array_key_exists($name, $this->shapes);
    }
}
