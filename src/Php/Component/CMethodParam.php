<?php

namespace Kanel\Enuma\Php\Component;

use Kanel\Enuma\CodingStyle\CodingStyle;
use Kanel\Enuma\Entity\Parameter;
use Kanel\Enuma\Token\TString;
use Kanel\Enuma\Token\TVariable;
use Kanel\Enuma\Token\TWhitespace;

class CMethodParam extends Component
{
    protected $parameter;

    public function __construct(Parameter $parameter,CodingStyle $codingStyle)
    {
        parent::__construct($codingStyle);
        $this->parameter = $parameter;
    }

    function toTokens(): array
    {
        $tokens = [];

        if ($this->parameter->getType()) {
            $tokens = [
                new TString($this->parameter->getType()),
                new TWhitespace(),
            ];
        }

        $tokens[] = new TVariable($this->parameter->getName());

        if ($this->parameter->hasValue()) {
            $tokens = array_merge(
                $tokens,
                [
                    new TWhitespace(),
                    '=',
                    new TWhitespace(),
                ],
                (new CValue($this->parameter->getValue(), $this->codingStyle))->toTokens()
            );
        }

        return $tokens;
    }
}