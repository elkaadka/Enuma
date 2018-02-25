<?php

namespace Kanel\Enuma\Entity\Interfaces;

interface Staticable
{
    public function isStatic();

    public function setIsStatic(bool $isStatic);
}