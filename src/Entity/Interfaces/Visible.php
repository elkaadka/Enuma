<?php

namespace Kanel\Enuma\Entity\Interfaces;

interface Visible
{
    public function getVisibility(): string;

    public function setVisibility(string $visibility);
}