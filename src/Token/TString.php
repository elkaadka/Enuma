<?php

namespace Kanel\Enuma\Token;

class TString extends Token
{
	public function __construct($value)
	{
		$this->token = [
			T_STRING,
			$value
		];
	}
}