<?php

namespace Kanel\Enuma\Php\Component;

use Kanel\Enuma\CodingStyle\CodingStyle;
use Kanel\Enuma\Token\TClass;
use Kanel\Enuma\Token\TString;
use Kanel\Enuma\Token\TWhitespace;

class CClass extends Component
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
            new TClass(),
            new TWhitespace(),
            new TString($this->name),
        ];
    }
}