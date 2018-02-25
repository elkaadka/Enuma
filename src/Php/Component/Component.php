<?php

namespace Kanel\Enuma\Php\Component;

use Kanel\Enuma\CodingStyle\CodingStyle;
use Kanel\Enuma\Token\TNsSeparator;
use Kanel\Enuma\Token\TString;

abstract class Component
{
    protected $codingStyle;

    public function __construct(CodingStyle $codingStyle)
    {
        $this->codingStyle = $codingStyle;
    }

    abstract function toTokens(): array;

    protected function explode(string $namespace): \Generator
    {
        $parts = explode('\\', $namespace);
        $separatorsCount = (count($parts) - 1);

        foreach ($parts as $index => $part) {
            yield new TString($part);
            if ($index < $separatorsCount) {
                yield new TNsSeparator();
            }
        }
    }
}