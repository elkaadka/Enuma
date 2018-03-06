<?php

namespace Kanel\Enuma\Php\Component;

use Kanel\Enuma\CodingStyle\CodingStyle;
use Kanel\Enuma\Token\TImplements;
use Kanel\Enuma\Token\TString;
use Kanel\Enuma\Token\TWhitespace;

class CImplements extends Component
{
    protected $previous;
    protected $interface;

    public function __construct(string $interface, CodingStyle $codingStyle, Component $previous = null)
    {
        parent::__construct($codingStyle);
        $this->interface = $interface;
        $this->previous = $previous;
    }

    function toTokens(): array
    {
        if ($this->previous) {
            $tokens = [
                new TWhitespace(),
                new TImplements(),
                new TWhitespace(),
            ];
        } else {
            $tokens = array_merge(
                $this->previous? $this->previous->toTokens() : [],
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