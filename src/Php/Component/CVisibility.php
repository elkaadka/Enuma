<?php

namespace Kanel\Enuma\Php\Component;

use Kanel\Enuma\CodingStyle\CodingStyle;
use Kanel\Enuma\Hint\Visibility;
use Kanel\Enuma\Token\TPrivate;
use Kanel\Enuma\Token\TProtected;
use Kanel\Enuma\Token\TPublic;
use Kanel\Enuma\Token\TWhitespace;

class CVisibility extends Component
{
    protected $visibility;

    public function __construct(string $visibility, CodingStyle $codingStyle)
    {
        parent::__construct($codingStyle);
        $this->visibility = $visibility;
    }

    function toTokens(): array
    {
        $tokens = [];

        switch ($this->visibility) {
            case Visibility::PUBLIC : $tokens = [new TPublic(), new TWhitespace()];
                break;
            case Visibility::PROTECTED : $tokens = [new TProtected(), new TWhitespace()];
                break;
            case Visibility::PRIVATE : $tokens = [new TPrivate(), new TWhitespace()];
                break;
        }

        return $tokens;
    }
}