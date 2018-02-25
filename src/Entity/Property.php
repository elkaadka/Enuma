<?php

namespace Kanel\Enuma\Entity;

use Kanel\Enuma\Entity\Interfaces\Nameable;
use Kanel\Enuma\Entity\Interfaces\Staticable;
use Kanel\Enuma\Entity\Interfaces\Valuable;
use Kanel\Enuma\Entity\Interfaces\Visible;
use Kanel\Enuma\Entity\Traits\NameTrait;
use Kanel\Enuma\Entity\Traits\StaticTrait;
use Kanel\Enuma\Entity\Traits\ValueTrait;
use Kanel\Enuma\Entity\Traits\VisibleTrait;
use Kanel\Enuma\Hint\Visibility;

class Property extends Entity implements Staticable, Nameable, Visible, Valuable
{
    use NameTrait;
    use StaticTrait;
    use VisibleTrait;
    use ValueTrait;

    public function __construct(string $name, string $visibility = Visibility::PUBLIC)
    {
        $this
            ->setName($name)
            ->setVisibility($visibility)
        ;
    }
}
