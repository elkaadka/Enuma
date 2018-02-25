<?php

namespace Kanel\Enuma\Php\Component;

use Kanel\Enuma\CodingStyle\CodingStyle;
use Kanel\Enuma\Entity\Method;
use Kanel\Enuma\Token\TString;
use Kanel\Enuma\Token\TWhitespace;

class CMethodBody extends Component
{
    protected $method;

    public function __construct(Method $method, CodingStyle $codingStyle)
    {
        parent::__construct($codingStyle);
        $this->method = $method;
    }

    function toTokens(): array
    {
        if ($this->codingStyle->isMethodBracesInNewLine()) {
            $tokens[] = new TWhitespace($this->codingStyle->getNewLine());
            $tokens[] = new TWhitespace($this->codingStyle->getIndentation());
        } else {
            $tokens[] = new TWhitespace();
        }

        $tokens[] = '{';
        $tokens[] = new TWhitespace($this->codingStyle->getNewLine());
        $tokens[] = new TWhitespace($this->codingStyle->getIndentation() . $this->codingStyle->getIndentation());
        $tokens[] = new TString('// TODO: Implement method body');
        $tokens[] = new TWhitespace($this->codingStyle->getNewLine());
        $tokens[] = new TWhitespace($this->codingStyle->getIndentation());
        $tokens[] = '}';
        $tokens[] = new TWhitespace($this->codingStyle->getNewLine());

        return $tokens;
    }
}