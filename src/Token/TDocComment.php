<?php

namespace Kanel\Enuma\Token;

class TDocComment extends Token
{
	public function __construct(string $comment)
	{
		$this->token = [
			T_DOC_COMMENT,
            $comment
		];
	}
}