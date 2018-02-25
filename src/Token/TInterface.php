<?php

namespace Kanel\Enuma\Token;

class TInterface extends Token
{
	public function __construct()
    {
        $this->token = [
			T_INTERFACE,
			'interface'
		];
    }
}