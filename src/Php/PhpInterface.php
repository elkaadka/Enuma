<?php

namespace Kanel\Enuma\Php;

use Kanel\Enuma\CodingStyle\CodingStyle;
use Kanel\Enuma\Entity\Property;
use Kanel\Enuma\Php\Component\CInterface;

class PhpInterface extends PhpClass
{
    public function __construct(string $name, CodingStyle $codingStyle = null)
    {
        parent::__construct($name, $codingStyle);
		$this->tokens[self::CLASS_KEY] = (new CInterface($name, $this->codingStyle))->toTokens();
    }

    /**
     * @param bool $isAbstract
     * @return PhpClass
     */
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

    public function useTrait(string $trait): PhpClass
    {
        return $this;
    }

    public function addProperty(Property $property): PhpClass
    {
        return $this;
    }
}