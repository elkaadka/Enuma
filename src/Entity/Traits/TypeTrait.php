<?php

namespace Kanel\Enuma\Entity\Traits;

trait TypeTrait
{
    protected $type;

    public function getType()
    {
        return $this->type;
    }

    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }
}