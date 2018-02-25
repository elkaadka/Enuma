<?php

namespace Kanel\Enuma\Token;

class TClass extends Token
{
	public function __construct()
	{
		$this->token = [
			T_CLASS,
			'class'
		];
	}
}
