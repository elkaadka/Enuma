<?php

namespace Kanel\Enuma;

use Kanel\Enuma\CodingStyle\CodingStyle;
use Kanel\Enuma\Php\Php;

class Enuma
{
	public function stringify(Php $php): string
	{
		$enumaString = '<?php'
		.  $php->getCodingStyle()->getNewLine()
		.  $php->getCodingStyle()->getNewLine();

		$enumaString .= $this->stroke($php->getTokens(Php::NAMESPACE_KEY), $php->getCodingStyle())
            . $this->stroke($php->getTokens(Php::USE_KEY), $php->getCodingStyle())
            . $this->stroke($php->getTokens(Php::CLASS_COMMENT), $php->getCodingStyle())
			. $this->stroke($php->getTokens(Php::ABSTRACT_KEY), $php->getCodingStyle())
			. $this->stroke($php->getTokens(Php::FINAL_KEY), $php->getCodingStyle())
			. $this->stroke($php->getTokens(Php::CLASS_KEY), $php->getCodingStyle())
			. $this->stroke($php->getTokens(Php::EXTENDS_KEY), $php->getCodingStyle())
			. $this->stroke($php->getTokens(Php::IMPLEMENTS_KEY), $php->getCodingStyle())
			. $this->stroke($php->getTokens(Php::CLASS_START), $php->getCodingStyle())
            . rtrim(
                $this->stroke($php->getTokens(Php::USE_TRAIT_KEY), $php->getCodingStyle())
                . $this->stroke($php->getTokens(Php::CONST_KEY), $php->getCodingStyle())
                . $this->stroke($php->getTokens(Php::PROPERTY_KEY), $php->getCodingStyle())
                . $this->stroke($php->getTokens(Php::METHODS_KEY), $php->getCodingStyle())
            )
            . $this->stroke($php->getTokens(Php::CLASS_END), $php->getCodingStyle())

        ;

		if ($php->getCodingStyle()->usePhpClosingTag()) {
			$enumaString .= $php->getCodingStyle()->getNewLine()
				. '?>';
		}

		return $enumaString;
	}

	public function save(Php $php, string $filename)
    {
        return file_put_contents($filename, $this->stringify($php));
    }

	public function load(string $filename): bool
	{
		if (!file_exists($filename)) {
			return false;
		}

		$phpClass = (new Tokenizer(file_get_contents($filename)))->toTokens();
	}

	protected function stroke($tokens, CodingStyle $codingStyle): string
	{
	    $_ = '';
        $addNewLine = false;

		if (is_array($tokens)) {
		    foreach ($tokens as $token) {
		        if (is_array($token)) {
                    $_ .= $this->stroke($token, $codingStyle);
                    $addNewLine = true;
                } else {
		            $_ .= $token;
                }
            }
		}

		if ($addNewLine) {
            $_ .= $codingStyle->getNewLine();
        }

		return $_;
	}
}
