<?php

namespace Kanel\Enuma\Php\Component;

use Kanel\Enuma\Token\TWhitespace;

class CClassEnd extends Component
{
    function toTokens(): array
    {
        $tokens =  [
            new TWhitespace($this->codingStyle->getNewLine()),
            '}'
        ];

        if (!$this->codingStyle->usePhpClosingTag() && $this->codingStyle->useUnixLineFeedEnding()) {
            $tokens[] = new TWhitespace($this->codingStyle->getNewLine());
        }

        return $tokens;
    }
}