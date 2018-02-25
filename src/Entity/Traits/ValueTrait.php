<?php

namespace Kanel\Enuma\Entity\Traits;

trait ValueTrait
{
    protected $value;
    protected $hasValue = false;

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->hasValue = true;
        $this->value = $value;

        return $this;
    }

    public function hasValue(): bool
    {
        return $this->hasValue;
    }
}
