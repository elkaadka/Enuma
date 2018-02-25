<?php

namespace Kanel\Enuma\Php\Component;

use Kanel\Enuma\CodingStyle\CodingStyle;
use Kanel\Enuma\Token\TDNumber;
use Kanel\Enuma\Token\TLNumber;
use Kanel\Enuma\Token\TString;

class CValue extends Component
{
    protected $value;

    public function __construct($value, CodingStyle $codingStyle)
    {
        parent::__construct($codingStyle);
        $this->value = $value;
    }

    function toTokens(): array
    {
        $tokens = [];

        switch (strtolower(gettype($this->value))) {
            case 'int':
            case 'integer' : $tokens[] = new TLNumber($this->value);
                break;
            case 'float'   :
            case 'double'  : $tokens[] = new TDNumber($this->value);
                break;
            case 'string'  : $tokens[] = new TString( "'" . str_replace('\'', '\\\'', $this->value) . "'");
                break;
            case 'null'    : $tokens[] = new TString( 'null');
                break;
            case 'array'   : $tokens = array_merge($tokens, (new CArray($this->value, $this->codingStyle))->toTokens());
                break;
            case 'bool'    :
            case 'boolean' : $tokens[] = new TString( $this->value? 'true':'false');
                break;
            default: $tokens[] = new TString( 'null');;
        }

        return $tokens;
    }
}
