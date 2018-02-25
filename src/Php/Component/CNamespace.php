<?php

namespace Kanel\Enuma\Php\Component;

use Kanel\Enuma\CodingStyle\CodingStyle;
use Kanel\Enuma\Token\TNamespace;
use Kanel\Enuma\Token\TWhitespace;

class CNamespace extends Component
{
    protected $namespace;

    public function __construct(string $namespace, CodingStyle $codingStyle)
    {
        $this->namespace = $namespace;
        parent::__construct($codingStyle);
    }

    function toTokens(): array
    {
        $tokens = [];

        if ($this->namespace && strpos($this->namespace, '\\') !== false) {
            $tokens = [
                new TNamespace(),
                new TWhitespace(),
            ];

            foreach ($this->explode($this->namespace) as $token) {
                $tokens[] = $token;
            }

            $tokens[] = ';';
            $tokens[] = new TWhitespace($this->codingStyle->getNewLine());
            $tokens[] = new TWhitespace($this->codingStyle->getNewLine());
        }

        return $tokens;
    }
}