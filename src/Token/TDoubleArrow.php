<?php

namespace Kanel\Enuma\Token;

class TDoubleArrow extends Token
{
    protected $array;

    public function __construct()
    {
        $this->token = [
            T_DOUBLE_ARROW,
            '=>',
        ];
    }
}