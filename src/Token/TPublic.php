<?php

namespace Kanel\Enuma\Token;

class TPublic extends Token
{
	public function __construct()
	{
		$this->token = [
			T_PUBLIC,
			'public'
		];
	}
}