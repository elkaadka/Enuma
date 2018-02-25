<?php

namespace Kanel\Enuma\Entity\Interfaces;

interface AbstractFinalable
{
    public function isAbstract();

    public function setIsAbstract(bool $isAbstract);

    public function isFinal();

    public function setIsFinal(bool $isFinal);
}