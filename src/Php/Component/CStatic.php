<?php

namespace Kanel\Enuma\Php\Component;

use Kanel\Enuma\Token\TStatic;
use Kanel\Enuma\Token\TWhitespace;

class CStatic extends Component
{
    function toTokens(): array
    {
        return [
            new TStatic(),
            new TWhitespace(),
        ];
    }
}