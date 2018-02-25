<?php

namespace Kanel\Enuma\Token;

abstract class Token
{
	protected $token;

	final public function getToken(): array
	{
		return $this->token;
	}

	final public function __toString(): string
	{
		return $this->token[1] ?? '';
	}
}