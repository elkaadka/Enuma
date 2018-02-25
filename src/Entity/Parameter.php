<?php

namespace Kanel\Enuma\Entity;

use Kanel\Enuma\Entity\Interfaces\Nameable;
use Kanel\Enuma\Entity\Interfaces\Typable;
use Kanel\Enuma\Entity\Interfaces\Valuable;
use Kanel\Enuma\Entity\Traits\NameTrait;
use Kanel\Enuma\Entity\Traits\TypeTrait;
use Kanel\Enuma\Entity\Traits\ValueTrait;

class Parameter extends Entity implements Nameable, Valuable, Typable
{
    use NameTrait;
    use ValueTrait;
    use TypeTrait;

    public function __construct(string $name)
    {
        $this->setName($name);
    }
}
