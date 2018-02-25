<?php

namespace Kanel\Enuma\Entity\Interfaces;

interface Commentable
{
    public function getComment();

    public function setComment(string $comment);
}