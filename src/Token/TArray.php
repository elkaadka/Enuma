<?php

namespace Kanel\Enuma\Token;

class TArray extends Token
{
    public function __construct()
	{
		$this->token = [
			T_ARRAY,
			'array',
		];
	}
}
