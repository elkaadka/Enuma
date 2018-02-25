<?php

namespace Kanel\Enuma\Php\Component;

use Kanel\Enuma\Token\TFinal;
use Kanel\Enuma\Token\TWhitespace;

class CFinal extends Component
{
    function toTokens(): array
    {
        return [
            new TFinal(),
            new TWhitespace(),
        ];
    }
}