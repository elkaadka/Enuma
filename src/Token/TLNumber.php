<?php

namespace Kanel\Enuma\Token;

class TLNumber extends Token
{
    public function __construct(int $value)
    {
        $this->token =  [
			T_LNUMBER,
			$value
		];
    }
}
