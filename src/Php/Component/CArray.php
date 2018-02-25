<?php

namespace Kanel\Enuma\Php\Component;

use Kanel\Enuma\CodingStyle\CodingStyle;
use Kanel\Enuma\Token\TArray;
use Kanel\Enuma\Token\TConstantEncapsedString;
use Kanel\Enuma\Token\TDoubleArrow;
use Kanel\Enuma\Token\TWhitespace;

class CArray extends Component
{
    protected $array;

    public function __construct(array $array, CodingStyle $codingStyle)
    {
        $this->array = $array;
        parent::__construct($codingStyle);
    }

    function toTokens(): array
    {
        $tokens = [];

        if ($this->codingStyle->isShortArrayNotation()) {
            $tokens[] = '[';
        } else {
            $tokens[] = new TArray();
            $tokens[] = '(';
        }

        $isAssociativeArray = (array_keys($this->array) !== range(0, count($this->array) - 1));

        $index = 0;
        $lastElementIndex = count($this->array) - 1;

        foreach ($this->array as $key =>  $value) {

            if ($isAssociativeArray) {
                $tokens = array_merge(
                    $tokens,
                    [
                        new TConstantEncapsedString("'" . str_replace('\'', '\\\'', $key) . "'"),
                        new TWhitespace(),
                        new TDoubleArrow(),
                        new TWhitespace(),
                    ]
                );
            }

            $tokens = array_merge($tokens, (new CValue($value, $this->codingStyle))->toTokens());

            if ($index < $lastElementIndex) {
                $tokens[] = ',';
                $tokens[] = new TWhitespace();
            }

            $index++;
        }

        if ($this->codingStyle->isShortArrayNotation()) {
            $tokens[] = ']';
        } else {
            $tokens[] = ')';
        }

        return $tokens;
    }
}