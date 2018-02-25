<?php

namespace Kanel\Enuma\Token;

class TConstantEncapsedString extends Token
{
	public function __construct($value)
	{
		$this->token = [
			T_CONSTANT_ENCAPSED_STRING,
			$value,
		];
	}
}
