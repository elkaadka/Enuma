<?php

namespace Kanel\Enuma\Php\Component;

use Kanel\Enuma\CodingStyle\CodingStyle;
use Kanel\Enuma\Token\TString;
use Kanel\Enuma\Token\TTrait;
use Kanel\Enuma\Token\TWhitespace;

class CTrait extends Component
{
    protected $name;

    public function __construct(string $name, CodingStyle $codingStyle)
    {
        parent::__construct($codingStyle);
        $this->name = $name;
    }

    function toTokens(): array
    {
        return [
            new TTrait(),
            new TWhitespace(),
            new TString($this->name),
        ];
    }
}