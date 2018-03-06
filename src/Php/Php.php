<?php

namespace Kanel\Enuma\Php;

use Kanel\Enuma\CodingStyle\CodingStyle;
use Kanel\Enuma\CodingStyle\Psr2;
use Kanel\Enuma\Entity\Method;
use Kanel\Enuma\Php\Component\CClassEnd;
use Kanel\Enuma\Php\Component\CClassStart;

abstract class Php
{
	protected $collection;
    protected $codingStyle;

    public function __construct(CodingStyle $codingStyle = null)
    {
        $this->codingStyle = $codingStyle ?? new Psr2();
		$this->collection = new Collection();
		$this->collection->add(new CClassStart($this->codingStyle));
		$this->collection->add(new CClassEnd($this->codingStyle));
    }

    public function getCodingStyle(): CodingStyle
    {
        return $this->codingStyle;
    }

    public static function parse(string $fullyQualifiedClassName): array
    {
        if (strpos($fullyQualifiedClassName, '\\') === false) {
			return [null, $fullyQualifiedClassName];
        }

		$namespace = $fullyQualifiedClassName;
        $classBaseName = basename(str_replace('\\', '/', $fullyQualifiedClassName));

        return [$namespace, $classBaseName];
    }

	public function getCollection()
	{
		return $this->collection ?? null;
	}
}
