<?php

namespace CommentService\Comment;

interface CommentInterface
{
    /**
     * @param array $commentData
     */
    public function __construct(array $commentData);

    public function getId(): ?int;

    public function setId(int $id): void;

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