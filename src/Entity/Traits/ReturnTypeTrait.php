<?php

namespace Kanel\Enuma\Entity\Traits;

trait ReturnTypeTrait
{
    protected $returnType;

    public function getReturnType()
    {
        return $this->returnType;
    }

    public function setReturnType(string $returnType)
    {
        $this->returnType = $returnType;

        return $this;
    }
}