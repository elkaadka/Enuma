<?php

namespace Kanel\Enuma\Php\Component;

use Kanel\Enuma\CodingStyle\CodingStyle;
use Kanel\Enuma\Token\TClass;
use Kanel\Enuma\Token\TDocComment;
use Kanel\Enuma\Token\TString;
use Kanel\Enuma\Token\TWhitespace;

class CComment extends Component
{
    protected $comment;
    protected $indent;

    public function __construct(string $comment, CodingStyle $codingStyle, bool $indent = false)
    {
        parent::__construct($codingStyle);
        $this->comment = $comment;
        $this->indent = $indent;
    }

    function toTokens(): array
    {
        $comment = str_replace(
            "\n",
            $this->codingStyle->getNewLine() . $this->codingStyle->getIndentation() . ' * ',
            ltrim($this->comment)
        );
        $indentation = ($this->indent ? $this->codingStyle->getIndentation() : '');

        $comment =
            $indentation .
            '/**'
            . $this->codingStyle->getNewLine()
            . $indentation
            . ' * '
            . $comment
            . $this->codingStyle->getNewLine()
            . $indentation
            . ' */'
            . $this->codingStyle->getNewLine();

        return [
            new TDocComment($comment),
        ];
    }
}