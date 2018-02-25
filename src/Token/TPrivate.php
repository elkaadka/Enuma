<?php

namespace Kanel\Enuma\Token;

class TPrivate extends Token
{
    public function __construct()
    {
        $this->token = [
			T_PRIVATE,
			'private'
		];
    }
}