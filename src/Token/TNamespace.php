<?php

namespace Kanel\Enuma\Token;

/**
 * Class TNamespace
 * Represents the namespace
 */
class TNamespace extends Token
{
    public function __construct()
    {
        $this->token = [
			T_NAMESPACE,
			'namespace'
        ];
    }
}