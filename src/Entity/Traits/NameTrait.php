<?php

namespace Kanel\Enuma\Entity\Traits;

trait NameTrait
{
    protected $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }
}