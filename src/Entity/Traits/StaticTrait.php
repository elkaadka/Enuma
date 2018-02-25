<?php

namespace Kanel\Enuma\Entity\Traits;


trait StaticTrait
{
    protected $isStatic;

    public function isStatic()
    {
        return $this->isStatic;
    }

    public function setIsStatic(bool $isStatic)
    {
        $this->isStatic = $isStatic;

        return $this;
    }
}