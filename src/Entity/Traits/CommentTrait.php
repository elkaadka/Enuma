<?php

namespace Kanel\Enuma\Entity\Traits;

trait CommentTrait
{
    protected $comment;

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment(string $comment)
    {
        $this->comment = $comment;
    }
}