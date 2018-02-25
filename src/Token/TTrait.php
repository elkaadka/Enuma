<?php

namespace Kanel\Enuma\Token;

class TTrait extends Token
{
	public function __construct()
	{
		$this->token = [
			T_TRAIT,
			'trait'
		];
	}
}