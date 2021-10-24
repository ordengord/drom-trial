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

    protected ?int $id = null;

    protected string $name;

    protected string $text;

    public function __construct(array $commentData)
    {
        if ($this->isValid($commentData) === false)
            throw new CommentValidateException();

        $this->name = $commentData['name'];
        $this->text = $commentData['text'];

        if (array_key_exists('id', $commentData)) {
            $this->id = $commentData['id'];
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
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