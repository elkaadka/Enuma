<?php

namespace Kanel\Enuma\Entity\Interfaces;

interface Bodyable
{
    public function getBody(): string;

    public function setBody(string $body);

    public function hasBody(): bool;
}