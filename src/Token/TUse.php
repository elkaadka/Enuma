<?php

namespace Kanel\Enuma\Token;

/**
 * Class TUse
 * Represents the "use class"
 */
class TUse extends Token
{
	public function __construct()
	{
		$this->token = [
			T_USE,
			'use'
		];
	}
}