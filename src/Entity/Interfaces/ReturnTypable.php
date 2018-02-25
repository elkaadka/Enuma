<?php

namespace Kanel\Enuma\Entity\Interfaces;

interface ReturnTypable
{
    public function getReturnType();

    public function setReturnType(string $type);
}