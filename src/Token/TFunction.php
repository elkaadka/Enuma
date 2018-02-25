<?php

namespace Kanel\Enuma\Token;

class TFunction extends Token
{
	public function __construct()
	{
		$this->token = [
			T_FUNCTION,
			'function',
		];
	}
}
