<?php

namespace Kanel\Enuma\Php\Component;

use Kanel\Enuma\CodingStyle\CodingStyle;
use Kanel\Enuma\Entity\Property;
use Kanel\Enuma\Token\TVariable;
use Kanel\Enuma\Token\TWhitespace;

class CProperty extends Component
{
    protected $property;

    public function __construct(Property $property, CodingStyle $codingStyle)
    {
        parent::__construct($codingStyle);
        $this->property = $property;
    }

    function toTokens(): array
    {
        $tokens = array_merge(
            [
                new TWhitespace($this->codingStyle->getIndentation())
            ],
            (new CVisibility($this->property->getVisibility(), $this->codingStyle))->toTokens(),
            $this->property->isStatic()? (new CStatic($this->codingStyle))->toTokens() : [],
            [
                new TVariable($this->property->getName())
            ]
        );


        if ($this->property->hasValue()) {
            $tokens = array_merge(
                $tokens,
                [
                    new TWhitespace(),
                    '=',
                    new TWhitespace(),
                ],
                (new CValue($this->property->getValue(), $this->codingStyle))->toTokens()
            );
        }

        $tokens[] = ';';
        $tokens[] = new TWhitespace($this->codingStyle->getNewLine());

        return $tokens;
    }
}