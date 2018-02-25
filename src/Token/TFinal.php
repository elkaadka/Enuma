<?php

namespace Kanel\Enuma\Token;

class TFinal extends Token
{
	public function __construct()
    {
        $this->token = [
			T_FINAL,
			'final',
		];
    }
}