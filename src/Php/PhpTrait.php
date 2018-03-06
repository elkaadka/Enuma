<?php

namespace Kanel\Enuma\Php;

use Kanel\Enuma\CodingStyle\CodingStyle;
use Kanel\Enuma\Entity\Constant;
use Kanel\Enuma\Php\Component\CTrait;

class PhpTrait extends PhpClass
{
    public function __construct(string $name, CodingStyle $codingStyle = null)
    {
        parent::__construct($name, $codingStyle);
		$this->collection->add(new CTrait($name, $this->codingStyle));
    }

    public function abstract(bool $isAbstract = true): PhpClass
    {
        return $this;
    }

    public function final(bool $isFinal = true): PhpClass
    {
        return $this;
    }

    public function extends(string $class): PhpClass
    {
        return $this;
    }

    public function implements(string $interface): PhpClass
    {
        return $this;
    }

    public function addConst(Constant $constant): PhpClass
    {
        return $this;
    }
}