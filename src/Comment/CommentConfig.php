<?php

namespace CommentService\Comment;

use CommentService\Exception\InvalidConfigException;

class CommentConfig
{
    protected const DEFAULT_COMMENT = BaseComment::class;
    protected string $className;

    public function __construct(array $config)
    {
        $this->className = $config['class'] ?? self::DEFAULT_COMMENT;
    }

    /**
     * Для разнообразия^^
     * @param string $attribute
     * @return mixed
     * @throws \Exception
     */
    public function __get(string $attribute)
    {
        return property_exists($this, $attribute)
            ? $this->$attribute
            : throw new InvalidConfigException('Не существующее свойство класса');
    }
}