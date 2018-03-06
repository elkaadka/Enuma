<?php

namespace Kanel\Enuma\Php;

use Kanel\Enuma\CodingStyle\CodingStyle;
use Kanel\Enuma\Entity\Constant;
use Kanel\Enuma\Entity\Method;
use Kanel\Enuma\Entity\Property;
use Kanel\Enuma\Php\Component\CAbstract;
use Kanel\Enuma\Php\Component\CClass;
use Kanel\Enuma\Php\Component\CClassEnd;
use Kanel\Enuma\Php\Component\CClassStart;
use Kanel\Enuma\Php\Component\CComment;
use Kanel\Enuma\Php\Component\CConst;
use Kanel\Enuma\Php\Component\CExtends;
use Kanel\Enuma\Php\Component\CFinal;
use Kanel\Enuma\Php\Component\CImplements;
use Kanel\Enuma\Php\Component\CMethod;
use Kanel\Enuma\Php\Component\CMethodBody;
use Kanel\Enuma\Php\Component\CNamespace;
use Kanel\Enuma\Php\Component\CProperty;
use Kanel\Enuma\Php\Component\CUse;
use Kanel\Enuma\Php\Component\CUseTrait;
use Kanel\Enuma\Token\TWhitespace;

class PhpClass extends Php
{
    public function __construct(string $name, CodingStyle $codingStyle = null)
    {
        parent::__construct($codingStyle);
		$this->collection->add(new CClass($name, $this->codingStyle));
    }

    public function namespace(string $namespace): PhpClass
    {
		$this->collection->add(new CNamespace($namespace, $this->codingStyle));

		return $this;
    }

    public function use(string $class): PhpClass
    {
		$this->collection->add(new CUse($class, $this->codingStyle));

        return $this;
    }

    public function addComment(string $comment)
    {
        $this->collection->add(new CComment($comment, $this->codingStyle));

        return $this;
    }

    public function abstract(bool $isAbstract = true): PhpClass
    {
        if ($isAbstract) {
            $this->collection->add(new CAbstract($this->codingStyle));
            $this->final(false);
        } else {
			$this->collection->remove(CAbstract::class);
        }

        return $this;
    }

    public function final(bool $isFinal = true): PhpClass
    {
        if ($isFinal) {
			$this->collection->add(new CFinal($this->codingStyle));
			$this->abstract(false);
        } else {
			$this->collection->remove(CFinal::class);
        }

        return $this;
    }

    public function extends(string $class): PhpClass
    {
        list($class, $classBaseName) = $this->parse($class);
        if ($class) {
			$this->use($class);
		}

		$this->collection->add(new CExtends($classBaseName, $this->codingStyle));

		return $this;
    }

    public function implements(string $interface): PhpClass
    {
		list($class, $interfaceBaseName) = $this->parse($interface);
		if ($class) {
			$this->use($class);
		}

		$this->collection->add(
			new CImplements(
				$interfaceBaseName,
				$this->codingStyle,
				$this->collection->get(CImplements::class)
			)
		);

        return $this;
    }

    public function useTrait(string $trait): PhpClass
    {
		list($trait, $traitBaseName) = $this->parse($trait);
		if ($trait) {
			$this->use($trait);
		}

		$this->collection->add(new CUseTrait($traitBaseName, $this->codingStyle));

        return $this;
    }

    public function addConst(Constant $constant): PhpClass
    {
		$this->collection->add(new CConst($constant, $this->codingStyle));

        return $this;
    }

    public function addProperty(Property $property): PhpClass
    {
		$this->collection->add(new CProperty($property, $this->codingStyle));

        return $this;
    }

    public function addMethod(Method $method): PhpClass
    {
        $this->prepareMethod($method);

		$cComment = null;
		if ($method->getComment()) {
            $cComment = new CComment($method->getComment(), $this->codingStyle, true);
        }

        $methodHasBody = true;
        if ($method->isAbstract() || $this instanceof PhpInterface) {
			$methodHasBody = false;
		}

		$this->collection->add(
			new CMethod(
				$method,
				$this->codingStyle,
				$cComment,
				new CMethodBody($methodHasBody, $this->codingStyle)
			)
		);

        return $this;
    }

    protected function prepareMethod(Method $method)
    {
        if ($this instanceof PhpInterface) {
            $method->setIsAbstract(false);
        }

        if ($method->isAbstract()) {
            $this->abstract(true);
        }

        $comments = $method->getComment();

        foreach ($method->getParameters() as $parameter) {
            if ($parameter->getType()) {
                list($type, $typeBaseName) = $this->parse($parameter->getType());
                if ($type) {
                    $this->use($type);
                }
                $parameter->setType($typeBaseName);
            }

            if ($this->codingStyle->generateAutoComments()) {
                $comments .= $this->codingStyle->getNewLine()
                    . '@param '
                    . ($parameter->getType()? : 'mixed')
                    . ' $'
                    . $parameter->getName();
            }
        }

        if ($method->getReturnType()) {
            list($type, $typeBaseName) = $this->parse($method->getReturnType());
            if ($type) {
                $this->use($type);
                $method->setReturnType($typeBaseName);
            }
        }

        if ($this->codingStyle->generateAutoComments()) {
            $comments .= $this->codingStyle->getNewLine()
                . '@return '
                . ($method->getReturnType()? : 'mixed');
        }

        $method->setComment($comments ?? '');
    }
}