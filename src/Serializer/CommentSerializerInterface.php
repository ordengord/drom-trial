<?php

declare(strict_types=1);

namespace CommentService\Serializer;

use CommentService\Comment\CommentInterface;

interface CommentSerializerInterface
{
    public function serialize(CommentInterface $comment): string;

    public function deserialize(string $commentData): CommentInterface;

    /**
     * @param string $commentsData
     * @return CommentInterface[]
     */
    public function deserializeArray(string $commentsData): array;
}