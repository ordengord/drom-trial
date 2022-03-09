<?php

namespace CommentService\Comment;

use CommentService\Exception\Validation\CommentValidateException;
use Rakit\Validation\Validator;

/**
 * Простой комментарий
 */
class BaseComment implements CommentInterface
{
    protected static array $validationRules = [
        'id' => 'nullable|integer',
        'name' => 'required',
        'text' => 'required'
    ];

    /**
     * @var int|null
     */
    protected ?int $id;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $text;

    public function __construct(string $name, string $text, ?int $id = null)
    {
        $this->name = trim($name);
        $this->text = trim($text);
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getText(): string
    {
        return $this->text;
    }

    #[ArrayShape(['id' => "int|mixed", 'name' => "string", 'text' => "string"])]
    public function toClientArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'text' => $this->text
        ];
    }

    /**
     * @return array
     */
    public function toRequestArray(): array
    {
        $always = [
            'name' => $this->name,
            'text' => $this->text
        ];

        if (empty($this->id))
            return $always;

        return array_merge($always, ['id' => $this->id]);
    }

    /**
     * @param array $commentData
     * @return bool
     */
    protected function isValid(array $commentData): bool
    {
        $validator = new Validator();
        $validation = $validator->validate($commentData, static::$validationRules);
        return $validation->passes();
    }
}