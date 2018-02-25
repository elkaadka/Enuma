<?php

namespace Kanel\Enuma\Entity\Traits;

use Kanel\Enuma\Hint\Visibility as VisibilityHint;
use Kanel\Enuma\Hint\Visibility;

trait VisibleTrait
{
    protected $visibility;

    public function getVisibility(): string
    {
        return $this->visibility ?? Visibility::NONE;
    }

    public function setVisibility(string $visibility)
    {
        if (!in_array($visibility, [Visibility::NONE, VisibilityHint::PRIVATE, VisibilityHint::PROTECTED, VisibilityHint::PUBLIC])) {
            $visibility = VisibilityHint::PUBLIC;
        }

        $this->visibility = $visibility;

        return $this;
    }
}