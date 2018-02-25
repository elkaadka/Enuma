<?php

namespace Kanel\Enuma\Php\Component;

use Kanel\Enuma\Token\TWhitespace;

class CClassStart extends Component
{
    function toTokens(): array
    {
        return [
            $this->codingStyle->isClassBracesInNewLine()? new TWhitespace($this->codingStyle->getNewLine()) : new TWhitespace(),
            '{',
            new TWhitespace($this->codingStyle->getNewLine())
        ];;
    }
}