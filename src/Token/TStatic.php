<?php

namespace Kanel\Enuma\Token;

class TStatic extends Token
{
	public function __construct()
	{
		$this->token = [
			T_STATIC,
			'static'
		];
	}
}