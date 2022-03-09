<?php

namespace CommentService\Comment;

interface CommentInterface
{
    public function getId(): ?int;

    public function getName(): string;

    public function getText(): string;

    /**
     * Возвращает объект в массив, в котором комментарий
     * возвращается пользователю библиотеки (клиентскому приложению)
     * @return array
     */
    public function toClientArray(): array;

    /**
     * Возвращает объект в массив в котором он уйдет в http-запросе
     * @return array
     */
    public function toRequestArray(): array;
}