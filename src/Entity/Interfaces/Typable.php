<?php

namespace Kanel\Enuma\Entity\Interfaces;

interface Typable
{
    public function getType();

    public function setType(string $type);
}