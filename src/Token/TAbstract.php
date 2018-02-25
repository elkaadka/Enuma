<?php

namespace Kanel\Enuma\Token;

class TAbstract extends Token
{
	public function __construct()
	{
		$this->token = [
			T_ABSTRACT,
			'abstract',
		];
	}
}
