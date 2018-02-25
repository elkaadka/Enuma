<?php

namespace Kanel\Enuma\Php\Component;

use Kanel\Enuma\CodingStyle\CodingStyle;
use Kanel\Enuma\Token\TString;
use Kanel\Enuma\Token\TUse;
use Kanel\Enuma\Token\TWhitespace;

class CUseTrait extends Component
{
    protected $trait;

    public function __construct(string $trait, CodingStyle $codingStyle)
    {
        parent::__construct($codingStyle);
        $this->trait = $trait;
    }

    function toTokens(): array
    {
        return  [
            new TWhitespace($this->codingStyle->getIndentation()),
            new TUse(),
            new TWhitespace(),
            new TString($this->trait),
            ';',
            new TWhitespace($this->codingStyle->getNewLine()),
        ];
    }
}