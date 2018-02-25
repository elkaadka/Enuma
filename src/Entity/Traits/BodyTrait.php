<?php

namespace Kanel\Enuma\Entity\Traits;

trait BodyTrait
{
    protected $body;

    public function getBody(): string
    {
        return $this->body ?? '// TODO: Implement method body';
    }

    public function setBody(string $body)
    {
        $this->body = $body;
    }

    public function hasBody(): bool
    {
        return (bool)$this->body;
    }
}