<?php

namespace Kanel\Enuma\Token;

class TExtends extends Token
{
    public function __construct()
    {
        $this->token = [
            T_EXTENDS,
            'extends'
        ];
    }
}