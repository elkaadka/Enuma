<?php

namespace Kanel\Enuma\Entity;

use Kanel\Enuma\Entity\Interfaces\AbstractFinalable;
use Kanel\Enuma\Entity\Interfaces\Bodyable;
use Kanel\Enuma\Entity\Interfaces\Commentable;
use Kanel\Enuma\Entity\Interfaces\Nameable;
use Kanel\Enuma\Entity\Interfaces\ReturnTypable;
use Kanel\Enuma\Entity\Interfaces\Staticable;
use Kanel\Enuma\Entity\Interfaces\Visible;
use Kanel\Enuma\Entity\Traits\AbstractFinalTrait;
use Kanel\Enuma\Entity\Traits\BodyTrait;
use Kanel\Enuma\Entity\Traits\CommentTrait;
use Kanel\Enuma\Entity\Traits\NameTrait;
use Kanel\Enuma\Entity\Traits\ReturnTypeTrait;
use Kanel\Enuma\Entity\Traits\StaticTrait;
use Kanel\Enuma\Entity\Traits\VisibleTrait;
use Kanel\Enuma\Hint\Visibility;

class Method extends Entity implements Staticable, Nameable, Visible, AbstractFinalable, ReturnTypable, Commentable
{
    use NameTrait;
    use StaticTrait;
    use VisibleTrait;
    use AbstractFinalTrait;
    use ReturnTypeTrait;
    use CommentTrait;

    protected $parameters;

    public function __construct(string $name, string $visibility = Visibility::PUBLIC)
    {
    	$this->parameters = [];
        $this
            ->setName($name)
            ->setVisibility($visibility)
        ;
    }

	public function hasParameters(): bool
	{
		return !empty($this->parameters);
	}

    public function getParameters(): array
	{
		return $this->parameters;
	}

    public function addParameter(Parameter...$parameters)
    {
		$this->parameters = array_merge($this->parameters, $parameters);
    }
}
