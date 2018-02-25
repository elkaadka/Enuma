<?php

namespace Kanel\Enuma\Token;

class TVariable extends Token
{
	public function __construct($name)
	{
		$this->token = [
			T_VARIABLE,
			'$' . $name,
		];
	}
}