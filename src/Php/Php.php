<?php

namespace Kanel\Enuma\Php;

use Kanel\Enuma\CodingStyle\CodingStyle;
use Kanel\Enuma\CodingStyle\Psr2;
use Kanel\Enuma\Entity\Method;

abstract class Php
{
	const NAMESPACE_KEY = 0;
    const USE_KEY = 1;
    const CLASS_COMMENT = 2;
    const ABSTRACT_KEY = 3;
    const FINAL_KEY = 4;
    const CLASS_KEY = 5;
    const EXTENDS_KEY = 6;
    const IMPLEMENTS_KEY = 7;
    const CLASS_START = 8;
    const USE_TRAIT_KEY = 9;
    const CONST_KEY = 10;
	const PROPERTY_KEY = 11;
	const METHODS_KEY = 12;
	const CLASS_END = 13;

    protected $tokens;

    protected $codingStyle;

    public function __construct(CodingStyle $codingStyle = null)
    {
        $this->codingStyle = $codingStyle ?? new Psr2();
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

	public function getTokens(string $key)
	{
		return $this->tokens[$key] ?? null;
	}
}
