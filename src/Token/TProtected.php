<?php

namespace Kanel\Enuma\Token;

class TProtected extends Token
{
	public function __construct()
	{
		$this->token = [
			T_PROTECTED,
			'protected'
		];
	}
}