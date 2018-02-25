<?php

namespace Kanel\Enuma\Token;

class TWhitespace extends Token
{
    protected $whitespace;

    public function __construct(string $swhitespace = ' ')
    {
    	$this->token = [
			T_WHITESPACE,
			ctype_space($swhitespace)? $swhitespace : ' ',
		];
    }
}