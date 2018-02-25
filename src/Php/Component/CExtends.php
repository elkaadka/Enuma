<?php

namespace Kanel\Enuma\Php\Component;

use Kanel\Enuma\CodingStyle\CodingStyle;
use Kanel\Enuma\Token\TAbstract;
use Kanel\Enuma\Token\TClass;
use Kanel\Enuma\Token\TExtends;
use Kanel\Enuma\Token\TString;
use Kanel\Enuma\Token\TWhitespace;

class CExtends extends Component
{
    protected $class;

    public function __construct(string $class, CodingStyle $codingStyle)
    {
        $this->class = $class;
        parent::__construct($codingStyle);
    }

    function toTokens(): array
    {
        return [
            new TWhitespace(),
            new TExtends(),
            new TWhitespace(),
            new TString($this->class),
        ];
    }
}