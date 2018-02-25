<?php

namespace Kanel\Enuma\Entity\Interfaces;

interface Valuable
{
    public function getValue();

    public function setValue($value);

    public function hasValue(): bool;
}