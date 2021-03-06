<?php

namespace Kanel\Enuma\Php\Component;

use Kanel\Enuma\CodingStyle\CodingStyle;
use Kanel\Enuma\Entity\Method;
use Kanel\Enuma\Token\TFunction;
use Kanel\Enuma\Token\TString;
use Kanel\Enuma\Token\TWhitespace;

class CMethod extends Component
{
	protected $method;
	protected $cComment;
	protected $cMethodBody;

    public function __construct(Method $method, CodingStyle $codingStyle, CComment $cComment = null, CMethodBody $cMethodBody)
    {
        parent::__construct($codingStyle);
        $this->method = $method;
		$this->cComment = $cComment;
		$this->cMethodBody = $cMethodBody;
    }

    function toTokens(): array
    {
		$tokens = $this->cComment ? $this->cComment->toTokens() : [];

        $tokens[] = new TWhitespace($this->codingStyle->getIndentation());

        if ($this->method->isAbstract()) {
            $tokens = array_merge($tokens, (new CAbstract($this->codingStyle))->toTokens());
        }

        if ($this->method->isFinal()) {
            $tokens = array_merge($tokens, (new CFinal($this->codingStyle))->toTokens());
        }

        $tokens = array_merge($tokens, (new CVisibility($this->method->getVisibility(), $this->codingStyle))->toTokens());

        if ($this->method->isStatic()) {
            $tokens = array_merge($tokens, (new CStatic($this->codingStyle))->toTokens());
        }

        $tokens = array_merge(
            $tokens,
            [
                new TFunction(),
                new TWhitespace(),
                new TString($this->method->getName()),
                '(',
            ]
        );


        if ($this->method->hasParameters()) {

            $lastElementIndex = count($this->method->getParameters()) - 1;
            foreach ($this->method->getParameters() as $index => $parameter) {

                $tokens = array_merge(
                    $tokens,
                    (new CMethodParam($parameter, $this->codingStyle))->toTokens()
                );

                if ($index < $lastElementIndex) {
                    $tokens[] = ',';
                    $tokens[] = new TWhitespace();
                }
            }
        }

        $tokens[] = ')';

        if ($this->method->getReturnType()) {
            $tokens[] = ':';
            $tokens[] = new TWhitespace();
            $tokens[] = new TString($this->method->getReturnType());
        }

        $tokens = array_merge($tokens, $this->cMethodBody ? $this->cMethodBody->toTokens() : []);

        return $tokens;
    }
}