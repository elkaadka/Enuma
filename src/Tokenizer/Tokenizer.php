<?php

namespace Kanel\Enuma\Tokenizer;

use Kanel\Enuma\Php\PhpClass;

class Tokenizer
{
	protected $classContent;

	public function __construct(string $classContent)
	{
		$this->classContent = $classContent;
	}

	public function toTokens(): PhpClass
	{
		$tokens = token_get_all($this->classContent);
	}
}