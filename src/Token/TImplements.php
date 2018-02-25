<?php

namespace Kanel\Enuma\Token;

class TImplements extends Token
{
	public function __construct()
    {
        $this->token = [
			T_IMPLEMENTS,
			'implements'
		];
    }
}