<?php

namespace Kanel\Enuma\Php;

use Kanel\Enuma\Php\Component\CAbstract;
use Kanel\Enuma\Php\Component\CClass;
use Kanel\Enuma\Php\Component\CClassEnd;
use Kanel\Enuma\Php\Component\CClassStart;
use Kanel\Enuma\Php\Component\CComment;
use Kanel\Enuma\Php\Component\CConst;
use Kanel\Enuma\Php\Component\CExtends;
use Kanel\Enuma\Php\Component\CFinal;
use Kanel\Enuma\Php\Component\CImplements;
use Kanel\Enuma\Php\Component\CInterface;
use Kanel\Enuma\Php\Component\CMethod;
use Kanel\Enuma\Php\Component\CNamespace;
use Kanel\Enuma\Php\Component\Component;
use Kanel\Enuma\Php\Component\CProperty;
use Kanel\Enuma\Php\Component\CTrait;
use Kanel\Enuma\Php\Component\CUse;
use Kanel\Enuma\Php\Component\CUseTrait;

class Collection
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

	protected $components;

	public function add(Component $component)
	{
		$class = get_class($component);

		if ($this->isList($class)) {
			$this->components[$this->getKey($class)][] = $component;
		} else {
			$this->components[$this->getKey($class)] = $component;
		}
	}

	public function remove(string $componentClass) : bool
	{
		$key = $this->getKey($componentClass);
		if ($key < 0) {
			return false;
		}

		unset($this->components[$key]);

		return true;
	}

	public function get(string $componentClass)
	{
		$key = $this->getKey($componentClass);
		if ($key < 0) {
			return null;
		}

		return $this->components[$key] ?? null;
	}


	public function getKey(string $componentClass): int
	{
		switch ($componentClass) {
			case CClass::class      :
			case CTrait::class      :
			case CInterface::class  : return self::CLASS_KEY;
			case CClassStart::class : return self::CLASS_START;
			case CClassEnd::class   : return self::CLASS_END;
			case CNamespace::class  : return self::NAMESPACE_KEY;
			case CUse::class        : return self::USE_KEY;
			case CComment::class    : return self::CLASS_COMMENT;
			case CAbstract::class   : return self::ABSTRACT_KEY;
			case CFinal::class      : return self::FINAL_KEY;
			case CExtends::class    : return self::EXTENDS_KEY;
			case CImplements::class : return self::IMPLEMENTS_KEY;
			case CUseTrait::class   : return self::USE_TRAIT_KEY;
			case CConst::class      : return self::CONST_KEY;
			case CProperty::class   : return self::PROPERTY_KEY;
			case CMethod::class     : return self::METHODS_KEY;

			default: return -1;
		}
	}

	public function isList(string $componentClass): bool
	{
		switch ($componentClass) {
			case CUse::class :
			case CUseTrait::class :
			case CConst::class :
			case CProperty::class :
			case CMethod::class : return true;
			default: return false;
		}
	}
}