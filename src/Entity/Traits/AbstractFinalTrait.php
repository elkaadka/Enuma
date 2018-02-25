<?php

namespace Kanel\Enuma\Entity\Traits;

trait AbstractFinalTrait
{
    protected $isAbstract;
    protected $isFinal;

    public function isFinal()
    {
        return $this->isFinal;
    }

    public function setIsFinal(bool $isFinal)
    {
        $this->isFinal = $isFinal;
        $this->isAbstract = $isFinal? false : $this->isAbstract;

        return $this;
    }

    public function isAbstract()
    {
        return $this->isAbstract;
    }

    public function setIsAbstract(bool $isAbstract)
    {
        $this->isAbstract = $isAbstract;
        $this->isFinal = $isAbstract? false : $this->isFinal;

        return $this;
    }
}