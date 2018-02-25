<?php

namespace Kanel\Enuma\Php\Component;

use Kanel\Enuma\CodingStyle\CodingStyle;
use Kanel\Enuma\Entity\Constant;
use Kanel\Enuma\Token\TConst;
use Kanel\Enuma\Token\TString;
use Kanel\Enuma\Token\TWhitespace;

class CConst extends Component
{
    protected $const;

    public function __construct(Constant $const, CodingStyle $codingStyle)
    {
        parent::__construct($codingStyle);
        $this->const = $const;
    }

    function toTokens(): array
    {
        return array_merge(
            [
                new TWhitespace($this->codingStyle->getIndentation())
            ],
            (new CVisibility($this->const->getVisibility(), $this->codingStyle))->toTokens(),
            [
                new TConst(),
                new TWhitespace(),
                new TString($this->const->getName()),
                new TWhitespace(),
                '=',
                new TWhitespace(),
            ],
            (new CValue($this->const->getValue(), $this->codingStyle))->toTokens(),
            [
                ';',
                new TWhitespace($this->codingStyle->getNewLine())
            ]
        );
    }
}