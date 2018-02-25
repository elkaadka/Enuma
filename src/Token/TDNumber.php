<?php

namespace Kanel\Enuma\Token;

class TDNumber extends Token
{
    public function __construct(float $value)
    {
        $this->token = [
			T_DNUMBER,
			$value,
		];
    }
}
