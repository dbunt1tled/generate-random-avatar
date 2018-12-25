<?php

namespace DBUnt1tled\RandomAvatar\lib\shapes\classes;

use Intervention\Image\Image;

class RARectangle extends RAEllipse
{
    public const SHAPE_NAME = 'rectangle';

    /**
     * @return bool
     */
    public function isRound(): bool
    {
        return false;
    }

    /**
     * @param Image $image
     */
    public function applyImage(Image $image): void
    {
        $image->rectangle(
            $this->getBorder()->getWidth() / 2,
            $this->getBorder()->getWidth() / 2,
            $this->getWidth() - ($this->getBorder()->getWidth() / 2),
            $this->getHeight() - ($this->getBorder()->getWidth() / 2),
            function ($draw) {
                /** @var AbstractShape $draw */
                $draw->background($this->getBackground());
                if ($this->hasBorder()) {
                    $draw->border($this->getBorder()->getWidth(), $this->getBorder()->getColor());
                }
                return $draw;
            }
        );
    }
}
