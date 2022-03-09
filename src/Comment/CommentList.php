<?php

namespace CommentService\Comment;

class CommentList
{
    /**
     * @var CommentInterface[]
     */
    protected array $comments;

    /**
     * @param CommentInterface[] $comments
     */
    public function __construct(array $comments)
    {
        $this->comments = $comments;
    }

    //TODO тут могли бы быть методы для работы со списком комментариев - для пользователей библиотеки
    // Написал один

    public function count(): int
    {
        return count($this->comments);
    }
}