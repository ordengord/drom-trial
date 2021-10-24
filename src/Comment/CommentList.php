<?php

namespace CommentService\Comment;

class CommentList
{
    /**
     * @var CommentInterface[]
     */
    protected array $comments;

    public function __construct(string $className, array $commentsData)
    {
        foreach ($commentsData as $commentData) {
            $comment = new $className($commentData);
            $this->comments[] = $comment;
        }
    }

    //TODO тут могли бы быть методы для работы со списком комментариев - для пользователей библиотеки
    // Написал один

    public function count(): int
    {
        return count($this->comments);
    }
}