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

		$this->tokens[self::CLASS_KEY] = (new CClass($name, $this->codingStyle))->toTokens();
		$this->tokens[self::CLASS_START] = (new CClassStart($this->codingStyle))->toTokens();
		$this->tokens[self::CLASS_END] = (new CClassEnd($this->codingStyle))->toTokens();
    }

    public function namespace(string $namespace): PhpClass
    {
		$this->tokens[self::NAMESPACE_KEY] = (new CNamespace($namespace, $this->codingStyle))->toTokens();

		return $this;
    }

    public function use(string $class): PhpClass
    {
		$this->tokens[self::USE_KEY][] = (new CUse($class, $this->codingStyle))->toTokens();

        return $this;
    }

    public function addComment(string $comment)
    {
        $this->tokens[self::CLASS_COMMENT] = (new CComment($comment, $this->codingStyle))->toTokens();

        return $this;
    }

    public function abstract(bool $isAbstract = true): PhpClass
    {
        if ($isAbstract) {
            $this->tokens[self::ABSTRACT_KEY] = (new CAbstract($this->codingStyle))->toTokens();
            $this->final(false);
        } else {
            unset($this->tokens[self::ABSTRACT_KEY]);
        }

        return $this;
    }

    public function final(bool $isFinal = true): PhpClass
    {
        if ($isFinal) {
            $this->tokens[self::FINAL_KEY] = (new CFinal($this->codingStyle))->toTokens();
			$this->abstract(false);
        } else {
            unset($this->tokens[self::FINAL_KEY]);
        }

        return $this;
    }

    public function extends(string $class): PhpClass
    {
        list($class, $classBaseName) = $this->parse($class);
        if ($class) {
			$this->use($class);
		}

		$this->tokens[self::EXTENDS_KEY] = (new CExtends($classBaseName, $this->codingStyle))->toTokens();

		return $this;
    }

    public function implements(string $interface): PhpClass
    {
		list($class, $interfaceBaseName) = $this->parse($interface);
		if ($class) {
			$this->use($class);
		}

		$this->tokens[self::IMPLEMENTS_KEY] = (new CImplements(
		    $interfaceBaseName,
            $this->tokens[self::IMPLEMENTS_KEY] ?? [] ,
            $this->codingStyle)
        )->toTokens();

        return $this;
    }

    public function useTrait(string $trait): PhpClass
    {
		list($trait, $traitBaseName) = $this->parse($trait);
		if ($trait) {
			$this->use($trait);
		}

		$this->tokens[self::USE_TRAIT_KEY][] = (new CUseTrait($traitBaseName, $this->codingStyle))->toTokens();

        return $this;
    }

    public function addConst(Constant $constant): PhpClass
    {
        $this->tokens[self::CONST_KEY][] = (new CConst($constant, $this->codingStyle))->toTokens();

        return $this;
    }

    public function addProperty(Property $property): PhpClass
    {
        $this->tokens[self::PROPERTY_KEY][] = (new CProperty($property, $this->codingStyle))->toTokens();

        return $this;
    }

    public function addMethod(Method $method): PhpClass
    {
        $this->prepareMethod($method);

        $tokens = [];

		if ($method->getComment()) {
            $tokens = (new CComment($method->getComment(), $this->codingStyle, true))->toTokens();
        }

        $tokens = array_merge($tokens, (new CMethod($method, $this->codingStyle))->toTokens());

		if (!$method->isAbstract() || $this instanceof PhpInterface) {
            $tokens = array_merge(
                $tokens,
                (new CMethodBody($method, $this->codingStyle))->toTokens()
            );
        } else {
            $tokens[] = ';';

        }

        $tokens[] = new TWhitespace($this->codingStyle->getNewLine());

        $this->tokens[self::METHODS_KEY][] = $tokens;

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