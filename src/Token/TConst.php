<?php

namespace Kanel\Enuma\Token;

class TConst extends Token
{
	public function __construct()
	{
		$this->token = [
			T_CONST,
			'const'
		];
	}
}
