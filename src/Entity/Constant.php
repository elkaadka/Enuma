<?php

namespace Kanel\Enuma\Entity;

use Kanel\Enuma\Entity\Interfaces\Nameable;
use Kanel\Enuma\Entity\Interfaces\Valuable;
use Kanel\Enuma\Entity\Interfaces\Visible;
use Kanel\Enuma\Entity\Traits\NameTrait;
use Kanel\Enuma\Entity\Traits\ValueTrait;
use Kanel\Enuma\Entity\Traits\VisibleTrait;

class Constant extends Entity implements Visible, Nameable, Valuable
{
    use VisibleTrait;
    use ValueTrait;
    use NameTrait;

    public function __construct(string $name, $value, string $visibility = '')
    {
        $this
            ->setName($name)
            ->setValue($value)
            ->setVisibility($visibility);
    }
}
