<?php

namespace Kanel\Enuma\CodingStyle;

/**
 * Class CustomCodingStyle
 * Defines some custom coding style rules to generate the classes/methods/...
 * @package Kanel\ClassManipulation\CodingStyle
 */
class CustomCodingStyle extends CodingStyle
{
    const INDENTATION_TAB = "\t";
    const INDENTATION_SPACE = " ";

    /**
     * Sets the encoding
     * Default is UTF-8
     * @param string $encoding
     * @return CustomCodingStyle
     */
    public function setEncoding(string $encoding): CustomCodingStyle
    {
        if (in_array($encoding, mb_list_encodings())) {
            $this->encoding = $encoding;
        }

        return $this;
    }

    /**
     * Defines if the file needs to have a closin tag ?>
     * Default value is false
     * @param bool $usePhpClosingTag
     * @return CustomCodingStyle
     */
    public function setUsePhpClosingTag(bool $usePhpClosingTag): CustomCodingStyle
    {
        $this->usePhpClosingTag = $usePhpClosingTag;

        return $this;
    }

    /**
     * Defines the identation to use
     * Can either be spaces or tabs
     * Default is 4 spaces
     * @param string $indentation the indentation to uses
     * @param int $count the number of repetition for the indetation (4 spaces, 3 tabs, ...)
     * @return CustomCodingStyle
     */
    public function setIndentation(string $indentation, int $count): CustomCodingStyle
    {
        if ($indentation === self::INDENTATION_TAB || $indentation === self::INDENTATION_SPACE) {
            $this->indentation = str_pad('', $count, $indentation);
        }

        return $this;
    }

    /**
     * Tells if the opening brace { after the class name must be in a new line
     * True means yes, false means same line
     * Default value is true
     * @param bool $classBracesInNewLine
     * @return CustomCodingStyle
     */
    public function setClassBracesInNewLine(bool $classBracesInNewLine): CustomCodingStyle
    {
        $this->classBracesInNewLine = $classBracesInNewLine;

        return $this;
    }

    /**
     * Tells if the opening brace { after the method name must be in a new line
     * True means yes, false means same line
     * Default value is true
     * @param bool $methodBracesInNewLine
     * @return CustomCodingStyle
     */
    public function setMethodBracesInNewLine(bool $methodBracesInNewLine): CustomCodingStyle
    {
        $this->methodBracesInNewLine = $methodBracesInNewLine;

        return $this;
    }

    /**
     * Tells if the file needs to end with a linux Feed line \n
     * Default value is yes
     * @param bool $unixLineFeedEnding
     * @return CustomCodingStyle
     */
    public function setUnixLineFeedEnding(bool $unixLineFeedEnding): CustomCodingStyle
    {
        $this->unixLineFeedEnding = $unixLineFeedEnding;

        return $this;
    }

    /**
     * set to true if you want to use windows new lines \r\n
     * Set to false to use Unix new line \n
     * @param bool $useWindowsNewLine
     * @return CustomCodingStyle
     */
    public function useWindowsNewLine(bool $useWindowsNewLine): CustomCodingStyle
    {
        $this->newLine = $useWindowsNewLine? "\r\n" : "\n";

        return $this;
    }

    /**
     * Set to true in order to only use short array annotation: []
     * Set to false to only use standard array annotation: array()
     * @param bool $use
     * @return bool
     */
    public function useShortArrayNotation(bool $use)
    {
        return $this->shortArrayNotation = $use;
    }

    /**
     * Set to true in order to auto generate param and return doc comments above methods
     * Set to false to disable them
     * @param bool $auto
     * @return CustomCodingStyle
     */
    public function setAutoComments(bool $auto): CustomCodingStyle
    {
        $this->autoComment = $auto;

        return $this;
    }
}