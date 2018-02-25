<?php

namespace Kanel\Enuma\CodingStyle;

interface CodingStyleInterface
{
    public function getEncoding();

    public function usePhpClosingTag();

    public function getIndentation();

    public function isClassBracesInNewLine();

    public function isMethodBracesInNewLine();

    public function useUnixLineFeedEnding();

    public function getNewLine();

    public function isShortArrayNotation();

    public function generateAutoComments();
}
