<?php

namespace Kanel\Enuma\Entity\Interfaces;

interface Nameable
{
    public function getName(): string;

    public function setName(string $name);
}