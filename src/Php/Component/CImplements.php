<?php

namespace Kanel\Enuma\Php\Component;

use Kanel\Enuma\CodingStyle\CodingStyle;
use Kanel\Enuma\Token\TImplements;
use Kanel\Enuma\Token\TString;
use Kanel\Enuma\Token\TWhitespace;

class CImplements extends Component
{
    protected $previousTokens;
    protected $interface;

    public function __construct(string $interface, array $previousTokens, CodingStyle $codingStyle)
    {
        parent::__construct($codingStyle);
        $this->interface = $interface;
        $this->previousTokens = $previousTokens;
    }

    function toTokens(): array
    {
        if (empty($this->previousTokens)) {
            $tokens = [
                new TWhitespace(),
                new TImplements(),
                new TWhitespace(),
            ];
        } else {
            $tokens = array_merge(
                $this->previousTokens,
                [
                    ',',
                    new TWhitespace(),
                ]
            );
        }

        $tokens[] = new TString($this->interface);

        return $tokens;
    }
}