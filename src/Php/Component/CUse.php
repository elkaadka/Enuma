<?php

namespace Kanel\Enuma\Php\Component;

use Kanel\Enuma\CodingStyle\CodingStyle;
use Kanel\Enuma\Token\TUse;
use Kanel\Enuma\Token\TWhitespace;

class CUse extends Component
{
    protected $use;

    public function __construct(string $use, CodingStyle $codingStyle)
    {
        $this->use = $use;
        parent::__construct($codingStyle);
    }

    function toTokens(): array
    {
        $tokens = [];

        if ($this->use && strpos($this->use, '\\') !== false) {
            $tokens = [
                new TUse(),
                new TWhitespace(),
            ];

            foreach ($this->explode($this->use) as $token) {
                $tokens[] = $token;
            }

            $tokens[] = ';';
            $tokens[] = new TWhitespace($this->codingStyle->getNewLine());
        }

        return $tokens;
    }
}