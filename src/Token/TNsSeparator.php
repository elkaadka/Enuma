<?php

namespace Kanel\Enuma\Token;

class TNsSeparator extends Token
{
    public function __construct()
    {
        $this->token = [
            T_NS_SEPARATOR,
            '\\'
        ];
    }
}