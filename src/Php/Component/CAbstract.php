<?php

namespace Kanel\Enuma\Php\Component;

use Kanel\Enuma\Token\TAbstract;
use Kanel\Enuma\Token\TWhitespace;

class CAbstract extends Component
{
    function toTokens(): array
    {
        return [
            new TAbstract(),
            new TWhitespace(),
        ];
    }
}