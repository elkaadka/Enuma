<?php

namespace Kanel\Enuma\Php\Component;

use Kanel\Enuma\CodingStyle\CodingStyle;
use Kanel\Enuma\Entity\Method;
use Kanel\Enuma\Token\TString;
use Kanel\Enuma\Token\TWhitespace;

class CMethodBody extends Component
{
	protected $hasBody;

    public function __construct(bool $hasBody, CodingStyle $codingStyle)
    {
        parent::__construct($codingStyle);
        $this->hasBody = $hasBody;
    }

    function toTokens(): array
    {
		$tokens = [];

    	if (!$this->hasBody) {
			return [';', new TWhitespace($this->codingStyle->getNewLine())];
		}

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
		$tokens[] = new TWhitespace($this->codingStyle->getNewLine());

        return $tokens;
    }
}